<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    // Type Detail
    public function show($id)
    {
        $type = Type::findOrFail($id);
        return view('admin.dashboard.assets.detail_type', compact('type'));
    }

    // Type Detail
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

    // Type Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $type = Type::findOrFail($id);
        $type->name = $request->name;
        $type->save();

        return redirect()->route('admin.dashboard.types.detail', $id)
            ->with('success', 'Type name updated successfully.');
    }

    // Type Delete
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return redirect()->route('admin.dashboard.assets')
            ->with('success', 'Type deleted successfully.');
    }

}
