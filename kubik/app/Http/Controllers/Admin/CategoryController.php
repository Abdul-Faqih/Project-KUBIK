<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
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
}
