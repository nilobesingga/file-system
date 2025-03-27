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
        try {
            $user = Auth::user();

            // Validate if the user exists
            if (!$user) {
                abort(403, 'Unauthorized action.');
            }

            // Fetch user's categories
            $categories = $user->category; // Ensure the `category` relationship exists
            if (!$categories) {
                return back()->withErrors(['error' => 'No categories found for the user.']);
            }

            $categoryIds = $categories->pluck('id')->toArray();

            // Build the query for files
            $sortBy = request('sort', 'unread'); // Default to sorting by unread status
            $sortDirection = request('direction', 'desc'); // Default to descending

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
            } elseif ($sortBy === 'document_name') {
                $filesQuery->orderBy('document_name', $sortDirection);
            } elseif ($sortBy === 'category') {
                $filesQuery->join('categories', 'files.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $sortDirection);
            } else {
                $filesQuery->orderBy('created_at', $sortDirection);
            }

            // Paginate the results
            $files = $filesQuery->latest()->paginate(15);

            // Calculate additional data
            $totalFiles = $files->count();
            $storageUsage = 0; // Replace with actual logic if needed
            $recentUploadsCount = Files::whereIn('category_id', $categoryIds)
                ->where('created_at', '>=', now()->subDays(7))
                ->count();
            $newFiles = Files::whereIn('category_id', $categoryIds)
                ->where('created_at', '>=', now()->startOfDay())
                ->count();
            $category = Category::all();

            // Mock investment data
            $amountInvested = 0.00; // Replace with actual logic if needed
            $currency = 'USD';
            $numberOfBonds = 0; // Replace with actual logic if needed

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
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error in DashboardController@index: ' . $e->getMessage());

            // Return a user-friendly error message
            return back()->withErrors(['error' => 'An error occurred while loading the dashboard. Please try again later.']);
        }
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
