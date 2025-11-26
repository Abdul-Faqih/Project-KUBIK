<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Category;
use App\Models\AssetMaster;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetMasterController extends Controller
{
    /**
     * Show Detail Asset Master
     */
    public function show($id_master)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin.');
        }

        $master = AssetMaster::with(['type', 'category', 'assets'])
            ->where('id_master', $id_master)
            ->firstOrFail();

        $types = Type::all();
        $categories = Category::all();

        return view('admin.dashboard.assets.master_detail', compact('master', 'types', 'categories'));
    }

    /**
     * Show Create Page
     */
    public function create()
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin.');
        }

        $types = Type::all();
        $categories = Category::all();

        return view('admin.dashboard.assets.add_asset', compact('types', 'categories'));
    }

    /**
     * Store New Asset Master
     */
    public function store(Request $request)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin.');
        }

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

        // Create master
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

    /**
     * Update Asset Master
     */
    public function update(Request $request, $id)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin.');
        }

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
            if ($master->image_asset && file_exists(public_path('uploads/assetmasters/' . $master->image_asset))) {
                unlink(public_path('uploads/assetmasters/' . $master->image_asset));
            }
            $imageName = null;
        }

        // UPLOAD NEW IMAGE
        if ($request->hasFile('image_asset')) {
            if ($master->image_asset && file_exists(public_path('uploads/assetmasters/' . $master->image_asset))) {
                unlink(public_path('uploads/assetmasters/' . $master->image_asset));
            }

            $imageName = time() . '-' . uniqid() . '.' . $request->image_asset->extension();
            $request->image_asset->move(public_path('uploads/assetmasters'), $imageName);
        }

        // UPDATE MASTER
        $master->update([
            'name' => $request->name,
            'id_type' => $request->type_id,
            'id_category' => $request->category_id,
            'stock_total' => $request->stock_total,
            'description' => $request->description,
            'image_asset' => $imageName,
        ]);

        /**
         * SYNC CHILD ASSETS WITH NEW STOCK
         */
        $currentCount = $master->assets()->count();
        $newCount = (int) $request->stock_total;

        // Add assets
        if ($newCount > $currentCount) {
            $add = $newCount - $currentCount;

            for ($i = 0; $i < $add; $i++) {
                $lastId = Asset::max('id_asset');

                $newId = $lastId
                    ? 'AST' . str_pad(((int) substr($lastId, 3)) + 1, 5, '0', STR_PAD_LEFT)
                    : 'AST00001';

                Asset::create([
                    'id_asset' => $newId,
                    'id_master' => $master->id_master,
                    'condition' => 'Good',
                    'status' => 'Available',
                ]);
            }
        }

        // Remove assets
        if ($newCount < $currentCount) {
            $remove = $currentCount - $newCount;

            $assetsToRemove = $master->assets()
                ->orderBy('updated_at', 'DESC')
                ->take($remove)
                ->get();

            foreach ($assetsToRemove as $asset) {
                $asset->delete();
            }
        }

        return redirect()->route('admin.assetmasters.detail', $master->id_master)
            ->with('success', 'Asset Master updated successfully!');
    }

    /**
     * Delete Asset Master
     */
    public function destroy($id)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin.');
        }

        $master = AssetMaster::where('id_master', $id)->firstOrFail();

        if ($master->image_asset && file_exists(public_path('uploads/assetmasters/' . $master->image_asset))) {
            unlink(public_path('uploads/assetmasters/' . $master->image_asset));
        }

        foreach ($master->assets as $asset) {
            $asset->delete();
        }

        $master->delete();

        return redirect()->route('admin.dashboard.assets')
            ->with('success', 'Asset Master deleted successfully!');
    }
}
