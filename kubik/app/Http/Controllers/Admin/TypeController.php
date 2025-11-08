<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function create()
    {
        return view('admin.dashboard.assets.add_type');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        Type::create(['name' => $request->name]);
        return redirect()->route('admin.dashboard.assets')->with('success', 'Type added successfully!');
    }
}
