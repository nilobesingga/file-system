<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        $files = Files::with('user')->latest()->get();
        return view('admin.dashboard', compact('files'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10000'
        ]);

        $file = $request->file('file');
        $path = $file->store('public/files');

        Files::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully');
    }

    public function destroy($id)
    {
        $file = Files::findOrFail($id);
        Storage::delete($file->path);
        $file->delete();

        return redirect()->route('dashboard')->with('success', 'File deleted successfully');
    }
}
