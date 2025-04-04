<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Files;
use App\Models\Investment;
use App\Models\InvestmentStatistic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function dashboard()
    {
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
        $files = Files::where('created_by',Auth::user()->id)->where('is_delete',0)->with('user', 'category')->latest()->paginate(15);
        $categories = Category::all();
        $users = User::all();

        $totalFiles = $files->count();
        $unreadFilesCount = \App\Helpers\FileHelper::getNotication();
        $recentUploadsCount = Files::where('created_by',Auth::user()->id)->where('created_at', '>=', now()->subDays(7))->count();
        return view('admin.dashboard', compact('files', 'categories', 'users', 'totalFiles', 'unreadFilesCount', 'recentUploadsCount'));
    }

    public function upload(Request $request)
    {
        DB::beginTransaction();
        $request->validate([
            'file' => 'required|array',
            'file.*' => 'max:10000', // Validate each file
            'category_id' => 'required|exists:categories,id',
            'document_name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'statement_no' => 'required',
            'statement_period' => 'required',
            'number_of_bonds' => 'required',
            'amount_subscribed' => 'required|numeric',
            'currency' => 'required|string|max:3',
        ]);

        try {
            $categoryId = $request->category_id;
            $document_name = $request->document_name;
            $userId = $request->user_id;
            $statement_no = $request->statement_no;
            $statement_period = $request->statement_period;
            $number_of_bonds = $request->number_of_bonds;
            $amount_subscribed = $request->amount_subscribed;
            $currency = $request->currency;
            $category = Category::findOrFail($categoryId); // Fetch the category to get its name
            $categoryName = strtolower(str_replace(' ', '-', $category->name)); // Sanitize category name for folder (e.g., "My Category" -> "my-category")
            $files = $request->file('file');

            foreach ($files as $file) {
                $folderPath = "{$categoryName}"; // Path: storage/app/public/files/[category_name]
                $path = $file->store($folderPath, 'public'); // Store in storage/app/public/files/[category_name]/filename

                Files::create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $path, // Path will be like "files/my-category/filename.png"
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                    'document_name' => $document_name,
                    'statement_no' => $statement_no,
                    'statement_period' => $statement_period,
                    'statement_period' => $statement_period,
                    'number_of_bonds' => $number_of_bonds,
                    'amount_subscribed' => $amount_subscribed,
                    'currency' => $currency,
                    'created_by' => Auth::user()->id
                ]);
            }
            DB::commit();
            return response()->json(['success' => true], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()->getMessages(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $file = Files::findOrFail($id);
        Storage::delete($file->path);
        $file->update(['is_delete' => 1]);

        return redirect()->route('admin.upload')->with('success', 'File deleted successfully');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string'
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Category updated successfully');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['is_delete' => 1]);

        return redirect()->back()->with('success', 'Category deleted successfully');
    }

    public function assignUserToCategory(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->categories()->sync($request->category_ids); // Sync multiple categories

        return redirect()->back()->with('success', 'User assigned to categories successfully');
    }

    public function removeUserFromCategory(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->categories()->detach($request->category_ids); // Detach multiple categories

        return redirect()->back()->with('success', 'User removed from categories successfully');
    }

    public function showRegisterForm()
    {
        $categories = Category::all();
        $user = null;
        return view('admin.register', compact('categories','user'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['exists:categories,id'],
            // 'is_admin' => ['boolean']
        ]);
        $isAdmin = ($request->has('is_admin') && ($request->is_admin === "true" || $request->is_admin === true)) ? 1 : 0;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $isAdmin
        ]);

        // Assign the user to multiple categories
        if ($request->has('category_ids')) {
            $user->categories()->sync($request->category_ids);
        }

        return redirect()->route('admin.users')->with('success', 'User registered successfully');
    }

    public function listUsers()
    {
        $users = User::with('category')->get();
        return view('admin.users', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->categories()->detach(); // Remove category associations
        $user->files()->delete(); // Delete user's files
        $user->delete(); // Delete the user

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }

    public function showUpload()
    {
        $categories = Category::all();
        $files = Files::where('created_by',Auth::user()->id)->with('user', 'category')->latest()->paginate(15);
        $users = User::select('id', 'name')->get();
        return view('admin.upload', compact('categories','files','users'));
    }

    public function manageCategories()
    {
        $categories = Category::all();
        $users = User::all();
        return view('admin.categories', compact('categories', 'users'));
    }

    public function downloadFile(Files $file)
    {
        $path = storage_path('app/public/' . $file->path);
        if (file_exists($path)) {
            return response()->download($path, $file->name, [
                'Content-Type' => Storage::mimeType($file->path),
            ]);
        }
        abort(404, 'File not found');
    }
}
