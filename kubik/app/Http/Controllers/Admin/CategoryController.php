<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class CategoryController extends Controller
{
    /**
     * CATEGORY LIST PAGE
     */
    public function index()
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $categories = Category::with(['assetMasters', 'assets'])->get();

        //MENGAMBIL LOG
        $activities = Activity::where('subject_type', 'App\Models\Category') // Sesuaikan dengan isi kolom subject_type di DB
            ->with('causer') // Load data admin yang mengubah
            ->latest() // Urutkan dari yang terbaru
            ->limit(50) // Batasi 50 log terakhir biar tidak berat
            ->get();

        return view('admin.dashboard.categories', compact('categories', 'activities'));
    }

    /**
     * CATEGORY DETAIL PAGE
     */
    public function show($id)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $category = Category::findOrFail($id);

        return view('admin.dashboard.assets.detail_category', compact('category'));
    }

    /**
     * SHOW ADD CATEGORY FORM
     */
    public function create()
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        return view('admin.dashboard.assets.add_category');
    }

    /**
     * STORE NEW CATEGORY
     */
    public function store(Request $request)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.dashboard.categories')
            ->with('success', 'Category added successfully!');
    }

    /**
     * UPDATE CATEGORY NAME
     */
    public function update(Request $request, $id)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.dashboard.categories.detail', $id)
            ->with('success', 'Category updated successfully!');
    }

    /**
     * DELETE CATEGORY
     */
    public function destroy($id)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.dashboard.categories')
            ->with('success', 'Category deleted successfully!');
    }
}
