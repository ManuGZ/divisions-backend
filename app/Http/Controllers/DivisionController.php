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

    //Metodo POST
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45|unique:divisions',
            'parent_id' => 'nullable|exists:divisions,id',
            'ambassador_name' => 'nullable|string|max:100',
            'superior_division' => 'nullable|string|max:100'
        ]);

        $validated['level'] = rand(1, 10);
        $validated['collaborators_count'] = rand(0, 50);

        $division = Division::create($validated);

        //
        $division->superior_division = $validated['superior_division'] ?? null;
        $division->save();

        return response()->json($division, 201);
    }


    //Metodo GET
    public function show($id)
    {
        return Division::with(['parent','children'])
            ->findOrFail($id);
    }

    //Metodo PUT
    public function update(Request $request, $id)
    {
        $division = Division::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:45|unique:divisions,name,' . $id,
            'parent_id' => 'nullable|exists:divisions,id',
            'ambassador_name' => 'nullable|string|max:100',
            'superior_division' => 'nullable|string|max:100' 
        ]);

        $division->update($validated);

        return response()->json($division);
    }

    //Metodo DELETE
    public function destroy($id)
    {
        $division = Division::findOrFail($id);
        $division->delete();

        return response()->json(['message' => 'Division eliminada correctamente']);
    }


    //Metodo GET para obtener subdivisiones
    public function subdivisions($id)
    {
        $division = Division::findOrFail($id);
        return response()->json($division->children);
    }
}
