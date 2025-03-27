<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryUser;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Ensure the user has the correct relationship
        $categoryIds = CategoryUser::select('category_id')->where('user_id',$user->id)->pluck('category_id')->toArray(); // FIXED: Use correct relationship

        // Get sort parameters from the request (default to sorting by unread status)
        $sortBy = request('sort', 'unread');
        $sortDirection = request('direction', 'desc');

        // Build query for fetching files
        $filesQuery = Files::with('user', 'category')->where('is_delete',0)->whereIn('category_id', $categoryIds);

        // Sorting logic
        if ($sortBy === 'unread') {
            $filesQuery->leftJoin('file_user', function ($join) use ($user) {
                $join->on('files.id', '=', 'file_user.file_id')
                     ->where('file_user.user_id', $user->id);
            })
            ->select('files.*')
            ->orderByRaw("file_user.read_at IS NULL $sortDirection");
        } else {
            if ($sortBy === 'document_name') {
                $filesQuery->orderBy('document_name', $sortDirection);
            } elseif ($sortBy === 'category') {
                $filesQuery->join('categories', 'files.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $sortDirection);
            } else {
                $filesQuery->orderBy('created_at', $sortDirection);
            }
        }

        // Paginate results
        $files = $filesQuery->paginate(15);
        $totalFiles = Files::whereIn('category_id', $categoryIds)->where('is_delete',0)->count();
        $storageUsage = 0;

        // Count recent uploads (last 7 days)
        $recentUploadsCount = Files::whereIn('category_id', $categoryIds)
            ->where('is_delete',0)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // Count new files uploaded today
        $newFiles = Files::whereIn('category_id', $categoryIds)
            ->where('is_delete',0)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();

        // Get all categories
        $category = Category::all();

        // Mock Investment Data
        $amountInvested = 0.00;
        $currency = 'USD';
        $numberOfBonds = 0;

        // Generate Monthly Investment Data
        $currentMonth = Carbon::now()->month;
        $weeklyInvestments = array_fill(0, $currentMonth, 0);
        $weeklyBonds = array_fill(0, $currentMonth, 0);

        for ($i = 0; $i < $currentMonth; $i++) {
            $weeklyInvestments[$i] = 0 + ($i * 0);
            $weeklyBonds[$i] = $i * 0;
        }

        // Generate Month Labels
        $labels = [];
        for ($i = 0; $i < $currentMonth; $i++) {
            $labels[] = Carbon::createFromDate(null, $i + 1, 1)->format('M Y');
        }

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
            'weeklyInvestments',
            'weeklyBonds',
            'labels'
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
