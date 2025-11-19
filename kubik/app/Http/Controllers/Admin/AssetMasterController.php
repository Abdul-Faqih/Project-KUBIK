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
            'image_asset' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string'
        ]);

        // Upload image
        $imageName = null;
        if ($request->hasFile('image_asset')) {
            $imageName = time() . '-' . uniqid() . '.' . $request->image_asset->extension();
            $request->image_asset->move(public_path('uploads/assetmasters'), $imageName);
        }

        // Create new asset master
        AssetMaster::create([
            'name' => $request->name,
            'id_type' => $request->type_id,
            'id_category' => $request->category_id,
            'stock_total' => $request->stock_total,
            'image_asset' => $imageName,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard.assets')
            ->with('success', 'Asset Master added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type_id' => 'required|string',
            'category_id' => 'required|string',
            'stock_total' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image_asset' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $master = AssetMaster::findOrFail($id);

        $imageName = $master->image_asset;

        // CLEAR IMAGE
        if ($request->clear_image == "1") {

            if (
                $master->image_asset &&
                file_exists(public_path('uploads/assetmasters/' . $master->image_asset))
            ) {
                unlink(public_path('uploads/assetmasters/' . $master->image_asset));
            }

            $imageName = null;
        }

        // UPLOAD NEW IMAGE
        if ($request->hasFile('image_asset')) {

            // delete old image
            if (
                $master->image_asset &&
                file_exists(public_path('uploads/assetmasters/' . $master->image_asset))
            ) {
                unlink(public_path('uploads/assetmasters/' . $master->image_asset));
            }

            $imageName = time() . '-' . uniqid() . '.' . $request->image_asset->extension();
            $request->image_asset->move(public_path('uploads/assetmasters'), $imageName);
        }

        // UPDATE DB
        $master->update([
            'name' => $request->name,
            'id_type' => $request->type_id,
            'id_category' => $request->category_id,
            'stock_total' => $request->stock_total,
            'description' => $request->description,
            'image_asset' => $imageName,
        ]);

        return redirect()->route('admin.assetmasters.detail', $master->id_master)
            ->with('success', 'Asset Master updated successfully!');
    }
    public function destroy($id)
    {
        $master = AssetMaster::where('id_master', $id)->firstOrFail();

        // Hapus gambar
        if (
            $master->image_asset &&
            file_exists(public_path('uploads/assetmasters/' . $master->image_asset))
        ) {
            unlink(public_path('uploads/assetmasters/' . $master->image_asset));
        }

        // Hapus semua asset anak
        foreach ($master->assets as $asset) {
            $asset->delete();
        }

        // Hapus master
        $master->delete();

        return redirect()->route('admin.dashboard.assets')
            ->with('success', 'Asset Master deleted successfully!');
    }

}
