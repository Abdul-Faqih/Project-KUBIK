<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // Category Detail
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.dashboard.assets.detail_category', compact('category'));
    }

    // Add Category
    public function create()
    {
        return view('admin.dashboard.assets.add_category');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        Category::create(['name' => $request->name]);
        return redirect()->route('admin.dashboard.assets')->with('success', 'Category added successfully!');
    }

    // Category Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.dashboard.categories.detail', $id)
            ->with('success', 'Category name updated successfully.');
    }

    // Category Delete
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.dashboard.assets')
            ->with('success', 'Category deleted successfully.');
    }
}
