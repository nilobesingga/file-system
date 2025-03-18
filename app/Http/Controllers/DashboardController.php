<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Files;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = $user->category; // Get user's categories
        $categoryIds = $categories->pluck('id')->toArray();

        // Fetch all files where the category_id matches any of the user's categories
        $files = Files::with('user', 'category')
                     ->whereIn('category_id', $categoryIds)
                     ->latest()
                     ->paginate(15);

        $totalFiles = $files->count();
        $storageUsage =  0;
        $recentUploadsCount =   Files::whereIn('category_id', $categoryIds)
                                 ->where('created_at', '>=', now()->subDays(7))
                                 ->count();
        $category = Category::all();
        return view('dashboard', compact('files', 'totalFiles', 'storageUsage', 'recentUploadsCount', 'categories','category'));
    }
}
