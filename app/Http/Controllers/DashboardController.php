<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $files = Files::where('user_id', auth()->id())->latest()->get();
        return view('dashboard', compact('files'));
    }
}
