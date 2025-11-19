<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // Show Asset Detail
    public function show($id_asset)
    {
        // Ambil data asset lengkap dengan relasi type & category dari master
        $asset = Asset::with(['master.type', 'master.category'])
            ->where('id_asset', $id_asset)
            ->firstOrFail();

        return view('admin.dashboard.assets.detail', compact('asset'));
    }

    // Update Asset
    public function update(Request $request, $id)
    {
        $request->validate([
            'condition' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update([
            'condition' => $request->condition,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.assets.detail', $asset->id_asset)
            ->with('success', 'Asset updated successfully!');
    }

    // Delete Asset
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('admin.dashboard.assets')->with('success', 'Asset deleted successfully!');
    }
}
