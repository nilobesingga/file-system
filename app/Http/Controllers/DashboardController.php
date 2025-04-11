<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Files;
use App\Models\InvestmentStatistic;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if(isset($request->user_id) && $user->is_admin){
            $user = User::find($request->user_id);
        }
        if (!$user) {
            return redirect()->route('login');
        }

        $users = User::where('is_admin', 0)->get();
        // Ensure the user has the correct relationship
        $categoryIds = CategoryUser::select('category_id')->where('user_id',$user->id)->pluck('category_id')->toArray(); // FIXED: Use correct relationship

        // Get sort parameters from the request (default to sorting by unread status)
        $sortBy = request('sort', 'unread');
        $sortDirection = request('direction', 'desc');

        // Build query for fetching files
        $filesQuery = Files::with('user', 'category')->where('is_delete',0)->whereIn('category_id', $categoryIds)->where('files.user_id',$user->id);

        // Sorting logic
        if ($sortBy === 'unread') {
            $filesQuery->leftJoin('file_user', function ($join) use ($user) {
                $join->on('files.id', '=', 'file_user.file_id')
                     ->where('file_user.user_id', $user->id);
            })
            ->select('files.*')
            ->orderByRaw("file_user.read_at IS NULL $sortDirection");
        } else {
            switch ($sortBy) {
                case 'document_name':
                case 'statement_no':
                case 'statement_period':
                case 'number_of_bonds':
                case 'amount_subscribed':
                    $filesQuery->orderBy($sortBy, $sortDirection);
                    break;
                case 'category':
                    $filesQuery->join('categories', 'files.category_id', '=', 'categories.id')
                        ->orderBy('categories.name', $sortDirection);
                    break;
                default:
                    $filesQuery->orderBy('created_at', $sortDirection);
            }
        }

        // Paginate results
        $files = $filesQuery->paginate(15);
        $totalFiles = Files::whereIn('category_id', $categoryIds)->where('user_id',$user->id)->where('is_delete',0)->count();
        $storageUsage = 0;

        // Count recent uploads (last 7 days)
        $recentUploadsCount = Files::whereIn('category_id', $categoryIds)
            ->where('user_id',$user->id)
            ->where('is_delete',0)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // Count new files uploaded today
        $newFiles = \App\Helpers\FileHelper::getNotication();

        // $newFiles = Files::whereIn('category_id', $categoryIds)
        //     ->where('user_id',$user->id)
        //     ->where('is_delete',0)
        //     ->where('created_at', '>=', now()->startOfDay())
        //     ->count();

        // Get all categories
        $category = Category::whereIn('id',$categoryIds)->get();

        // Mock Investment Data
        $amountInvested = Files::whereIn('category_id', $categoryIds)
            ->where('user_id',$user->id)
            ->where('is_delete',0)
            ->sum('amount_subscribed');
        $currency = 'USD';

        // Generate Monthly Investment Data
        $currentMonth = Carbon::now()->month;
        $monthlyInvestments = [];
        $monthlyBonds = [];
        $labels = [];

        // Get monthly investments from database
        $investments = DB::table('files')
            ->select(
                DB::raw('MONTH(statement_period) as month'),
                DB::raw('SUM(amount_subscribed) as total_amount'),
                DB::raw('SUM(number_of_bonds) as total_bonds')
            )
            ->whereYear('statement_period', Carbon::now()->year)
            ->whereMonth('statement_period', '<=', $currentMonth)
            ->where('user_id', $user->id)
            ->where('is_delete', 0)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Generate data arrays in the correct order
        for ($i = 1; $i <= $currentMonth; $i++) {
            $investment = $investments->firstWhere('month', $i);
            $monthlyInvestments[] = $investment ? floatval($investment->total_amount) : 0;
            $monthlyBonds[] = $investment ? intval($investment->total_bonds) : 0;
            $labels[] = Carbon::createFromDate(null, $i, 1)->format('M Y');
        }

        // Make sure all arrays are properly indexed
        $monthlyInvestments = array_values($monthlyInvestments);
        $monthlyBonds = array_values($monthlyBonds);
        $labels = array_values($labels);
        $investor_code = $user->code;
        $netPerformance = InvestmentStatistic::where('investor_code', $user->code)
                            ->where('is_publish', 1)
                            ->sum('monthly_net_gain_loss');
        $accumilate = InvestmentStatistic::select('capital','monthly_net_percentage','number_of_bonds')
                            ->where('investor_code', $user->code)
                            ->where('is_publish', 1)
                            ->orderBy('year')
                            ->orderByRaw("FIELD(month, 'December', 'November', 'October', 'September', 'August', 'July', 'June', 'May', 'April', 'March', 'February', 'January')")
                            ->first();
        $netPerformance = ($netPerformance) ? round(($netPerformance / $accumilate->capital) * 100) : 0;
        $netYield = $accumilate->monthly_net_percentage ?? 0;
        $numberOfBonds = $accumilate->number_of_bonds ?? 0;
        $amountInvested = $accumilate->capital ?? 0;
        $user_id = $user->id;
        return view('dashboard', compact(
            'files',
            'newFiles',
            'totalFiles',
            'storageUsage',
            'recentUploadsCount',
            'category',
            'amountInvested',
            'currency',
            'numberOfBonds',
            'monthlyInvestments',
            'monthlyBonds',
            'labels',
            'investor_code',
            'netPerformance',
            'netYield',
            'users',
            'user_id'
        ));
    }

    public function toggleRead(Request $request, Files $file)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $isRead = $request->input('read', true);

        if ($isRead) {
            if (!$file->readers()->where('user_id', $user->id)->exists()) {
                $file->readers()->attach($user->id, ['read_at' => now()]);
            }
        } else {
            $file->readers()->detach($user->id);
        }

        return response()->json([
            'success' => true,
            'read' => $file->isReadByCurrentUser()
        ]);
    }
}
