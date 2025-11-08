<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Category;
use App\Models\AssetMaster;
use Illuminate\Http\Request;

class AssetMasterController extends Controller
{
    public function show($id_master)
    {
        // Ambil data master lengkap dengan type, category, dan daftar assets
        $master = AssetMaster::with(['type', 'category', 'assets'])
            ->where('id_master', $id_master)
            ->firstOrFail();

        return view('admin.dashboard.assets.master_detail', compact('master'));
    }

    public function create()
    {
        $types = Type::all();
        $categories = Category::all();
        return view('admin.dashboard.assets.add_asset', compact('types', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type_id' => 'required',
            'category_id' => 'required',
            'stock_total' => 'required|numeric|min:1',
            'image' => 'nullable|image|max:5120',
            'description' => 'nullable|string'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('assets', 'public');
        }

        AssetMaster::create([
            'name' => $request->name,
            'id_type' => $request->type_id,
            'id_category' => $request->category_id,
            'stock_total' => $request->stock_total,
            'image' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard.assets')->with('success', 'Asset added successfully!');
    }
}
