<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Division::with('children')
            ->whereNull('parent_id')
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45|unique:divisions',
            'parent_id' => 'nullable|exists:divisions,id',
            'ambassador_name' => 'nullable|string|max:100'
        ]);

        $validated['level'] = rand(1, 10);
        $validated['collaborators_count'] = rand(0, 50);

        $division = Division::create($validated);

        return response()->json($division, 201);
    }

    public function show($id)
    {
        return Division::with(['parent','children'])
            ->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $division = Division::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:45|unique:divisions,name,' . $id,
            'parent_id' => 'nullable|exists:divisions,id',
            'ambassador_name' => 'nullable|string|max:100'
        ]);

        $division->update($validated);

        return response()->json($division);
    }

    public function destroy($id)
    {
        $division = Division::findOrFail($id);
        $division->delete();

        return response()->json(['message' => 'Division eliminada correctamente']);
    }

    public function subdivisions($id)
    {
        $division = Division::findOrFail($id);
        return response()->json($division->children);
    }
}
