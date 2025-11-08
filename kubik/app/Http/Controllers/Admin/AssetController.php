<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;

class AssetController extends Controller
{
    public function show($id_asset)
    {
        // Ambil data asset lengkap dengan relasi type & category dari master
        $asset = Asset::with(['master.type', 'master.category'])
            ->where('id_asset', $id_asset)
            ->firstOrFail();

        return view('admin.dashboard.assets.detail', compact('asset'));
    }
}
