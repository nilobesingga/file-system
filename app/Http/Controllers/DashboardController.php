<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // $files = Files::with('user', 'category')->where('user_id', auth()->id())->latest()->get();
        // return view('dashboard', compact('files'));

        $user = auth()->user();
        $categories = $user->category; // Get user's categories
        $categoryIds = $categories->pluck('id')->toArray();

        // Fetch all files where the category_id matches any of the user's categories
        $files = Files::with('user', 'category')
                     ->whereIn('category_id', $categoryIds)
                     ->latest()
                     ->paginate(15);

        $totalFiles = $files->count();
        $storageUsage =  0;//Files::whereIn('category_id', $categoryIds)->sum(function ($file) {
        //     return Storage::disk('public')->size($file->path);
        // });
        $recentUploadsCount = Files::whereIn('category_id', $categoryIds)
                                 ->where('created_at', '>=', now()->subDays(7))
                                 ->count();

        return view('dashboard', compact('files', 'totalFiles', 'storageUsage', 'recentUploadsCount', 'categories'));
    }
}
