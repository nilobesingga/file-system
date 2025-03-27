<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Files;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::where('id',Auth::user()->id)->first();
        $categories = $user->category; // Get user's categories
        $categoryIds = $categories->pluck('id')->toArray();

        // Fetch all files where the category_id matches any of the user's categories
        // Get sort parameters from the request (default to sorting by unread status)
        $sortBy = request('sort', 'unread'); // Default to sorting by unread status
        $sortDirection = request('direction', 'desc'); // Default to descending (unread first)

        // Build the query
        $filesQuery = Files::with('user', 'category')
            ->whereIn('category_id', $categoryIds);

        // Apply sorting
        if ($sortBy === 'unread') {
            $filesQuery->leftJoin('file_user', function ($join) use ($user) {
                $join->on('files.id', '=', 'file_user.file_id')
                     ->where('file_user.user_id', $user->id);
            })
            ->select('files.*')
            ->orderByRaw("CASE WHEN file_user.read_at IS NULL THEN 0 ELSE 1 END $sortDirection");
        } else {
            // Handle other sorting options (e.g., by document name, category, or upload date)
            if ($sortBy === 'document_name') {
                $filesQuery->orderBy('document_name', $sortDirection);
            } elseif ($sortBy === 'category') {
                $filesQuery->join('categories', 'files.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $sortDirection);
            } else {
                // Default to sorting by created_at (upload date)
                $filesQuery->orderBy('created_at', $sortDirection);
            }
        }

        // Paginate the results
        $files = $filesQuery->latest()->paginate(15);
        $totalFiles = $files->count();
        $storageUsage =  0;
        $recentUploadsCount =   Files::whereIn('category_id', $categoryIds)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $newFiles = Files::whereIn('category_id', $categoryIds)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();
        $category = Category::all();
        // Calculate weekly investment amounts (last 6 weeks)
        // Calculate total amount invested (mock data)
        $amountInvested = 0.00; // Total: $100,000 USD
        $currency = 'USD';

        // Calculate total number of bonds (mock data)
        $numberOfBonds = 0; // Total: 15 bonds

        // Mock monthly investment amounts (from January to current month)
        $currentMonth = Carbon::now()->month;
        $weeklyInvestments = array_fill(0, $currentMonth, 0);
        $weeklyBonds = array_fill(0, $currentMonth, 0);

        for ($i = 0; $i < $currentMonth; $i++) {
            $weeklyInvestments[$i] = 10000 + ($i * 5000); // Example data
            $weeklyBonds[$i] = 2 + $i; // Example data
        }

        // Generate month labels (e.g., "January", "February")
        $labels = [];
        for ($i = 0; $i < $currentMonth; $i++) {
            $labels[] = Carbon::createFromDate(null, $i + 1, 1)->format('M Y');
        }
        dd(Auth::user());
        return view('dashboard', compact(
            'files',
            'newFiles',
            'totalFiles',
            'storageUsage',
            'recentUploadsCount',
            'categories',
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
        $isRead = $request->input('read', true); // Default to true if not provided

        if ($isRead) {
            // Mark as read (attach the user to the file)
            if (!$file->readers()->where('user_id', $user->id)->exists()) {
                $file->readers()->attach($user->id, ['read_at' => now()]);
            }
        } else {
            // Mark as unread (detach the user from the file)
            $file->readers()->detach($user->id);
        }

        return response()->json([
            'success' => true,
            'read' => $file->isReadByCurrentUser()
        ]);
    }
}
