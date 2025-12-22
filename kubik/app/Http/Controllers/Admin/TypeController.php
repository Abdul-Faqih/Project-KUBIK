<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class TypeController extends Controller
{
    /**
     * ==============================
     *        TYPE LIST PAGE
     * ==============================
     */
    public function index()
    {
        // Auth check
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        // Ambil type + hitungan assets & assetMasters
        $types = Type::with(['assetMasters', 'assets'])
            ->orderBy('id_type')
            ->get();

        //MENGAMBIL LOG
        $activities = Activity::where('subject_type', 'App\Models\Type') // Sesuaikan dengan isi kolom subject_type di DB
            ->with('causer') // Load data admin yang mengubah
            ->latest() // Urutkan dari yang terbaru
            ->limit(50) // Batasi 50 log terakhir biar tidak berat
            ->get();

        return view('admin.dashboard.types', compact('types', 'activities'));
    }

    /**
     * ==============================
     *        TYPE DETAIL PAGE
     * ==============================
     */
    public function show($id_type)
    {
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        $type = Type::with(['assetMasters', 'assets'])
            ->where('id_type', $id_type)
            ->firstOrFail();

        return view('admin.dashboard.assets.detail_type', compact('type'));
    }

    /**
     * ==============================
     *        ADD TYPE FORM
     * ==============================
     */
    public function create()
    {
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard.assets.add_type');
    }

    /**
     * ==============================
     *        STORE NEW TYPE
     * ==============================
     */
    public function store(Request $request)
    {
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        Type::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.dashboard.types')
            ->with('success', 'Type added successfully!');
    }

    /**
     * ==============================
     *        UPDATE TYPE
     * ==============================
     */
    public function update(Request $request, $id_type)
    {
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $type = Type::where('id_type', $id_type)->firstOrFail();

        $type->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.dashboard.types.detail', $id_type)
            ->with('success', 'Type updated successfully.');
    }

    /**
     * ==============================
     *        DELETE TYPE
     * ==============================
     */
    public function destroy($id_type)
    {
        if (!admin()) {
            return redirect()->route('admin.login');
        }

        $type = Type::where('id_type', $id_type)->firstOrFail();

        // Hapus type
        $type->delete();

        return redirect()->route('admin.dashboard.types')
            ->with('success', 'Type deleted successfully.');
    }
}
