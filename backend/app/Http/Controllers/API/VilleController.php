<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ville;
use Illuminate\Http\Request;

class VilleController extends Controller
{
    public function index()
    {
        $villes = Ville::all();
        return response()->json($villes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:villes,nom',
            'region' => 'required|string|max:255',
            'code_postal' => 'nullable|string|max:10',
        ]);

        $ville = Ville::create($request->only(['nom', 'region', 'code_postal']));

        return response()->json($ville, 201);
    }

    public function show(Ville $ville)
    {
        return response()->json($ville);
    }

    public function update(Request $request, Ville $ville)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:villes,nom,' . $ville->id,
            'region' => 'required|string|max:255',
            'code_postal' => 'nullable|string|max:10',
        ]);

        $ville->update($request->only(['nom', 'region', 'code_postal']));

        return response()->json($ville);
    }

    public function destroy(Ville $ville)
    {
        $ville->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $villes = Ville::where('nom', 'like', "%$query%")
                      ->orWhere('region', 'like', "%$query%")
                      ->orWhere('code_postal', 'like', "%$query%")
                      ->get();
        return response()->json($villes);
    }
}