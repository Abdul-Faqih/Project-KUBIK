<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Menampilkan detail asset
     */
    public function show($id_asset)
    {
        // Cek apakah admin login
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        // Ambil asset + relasi master/type/category
        $asset = Asset::with(['master.type', 'master.category'])
            ->where('id_asset', $id_asset)
            ->firstOrFail();

        return view('admin.dashboard.assets.detail', compact('asset'));
    }

    /**
     * Update asset
     */
    public function update(Request $request, $id_asset)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $request->validate([
            'condition' => 'required|string|max:50',
            'status' => 'required|string|max:50',
        ]);

        $asset = Asset::findOrFail($id_asset);

        // Update nilai
        $asset->condition = $request->condition;
        $asset->status = $request->status;

        // Jika tabel asset punya kolom id_admin, otomatis catat admin yg update
        if (isset($asset->id_admin)) {
            $asset->id_admin = admin()->id_admin;
        }

        $asset->save();

        return redirect()->route('admin.assets.detail', $asset->id_asset)
            ->with('success', 'Asset updated successfully!');
    }

    /**
     * Delete asset
     */
    public function destroy($id_asset)
    {
        if (!admin()) {
            return redirect()->route('admin.login')->with('error', 'Please login first.');
        }

        $asset = Asset::findOrFail($id_asset);
        $asset->delete();

        return redirect()->route('admin.dashboard.assets')
            ->with('success', 'Asset deleted successfully!');
    }
}
