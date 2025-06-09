<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TypeBien;
use Illuminate\Http\Request;

class TypeBienController extends Controller
{
    public function index()
    {
        $typesBien = TypeBien::all();
        return response()->json($typesBien);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:types_biens,nom',
            'description' => 'nullable|string'
        ]);

        $typeBien = TypeBien::create($request->only(['nom', 'description']));

        return response()->json($typeBien, 201);
    }

    public function show(TypeBien $typeBien)
    {
        return response()->json($typeBien);
    }

    public function update(Request $request, TypeBien $typeBien)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:types_biens,nom,' . $typeBien->id,
            'description' => 'nullable|string'
        ]);

        $typeBien->update($request->only(['nom', 'description']));

        return response()->json($typeBien);
    }

    public function destroy(TypeBien $typeBien)
    {
        // Vérifier s'il y a des biens associés
        if ($typeBien->biens()->count() > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer ce type de bien car il est utilisé par des biens immobiliers.'
            ], 409);
        }

        $typeBien->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $typesBien = TypeBien::where('nom', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%")
                            ->get();
        return response()->json($typesBien);
    }
}