<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Proprietaire;
use Illuminate\Http\Request;

class ProprietaireController extends Controller
{
    public function index()
    {
        $proprietaires = Proprietaire::all();
        return response()->json($proprietaires);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:proprietaires,email',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);

        $proprietaire = Proprietaire::create($request->only(['nom', 'email', 'telephone', 'adresse']));

        return response()->json($proprietaire, 201);
    }

    public function show(Proprietaire $proprietaire)
    {
        return response()->json($proprietaire);
    }

    public function update(Request $request, Proprietaire $proprietaire)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:proprietaires,email,' . $proprietaire->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);

        $proprietaire->update($request->only(['nom', 'email', 'telephone', 'adresse']));

        return response()->json($proprietaire);
    }

    public function destroy(Proprietaire $proprietaire)
    {
        $proprietaire->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $proprietaires = Proprietaire::where('nom', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->get();
        return response()->json($proprietaires);
    }
}
