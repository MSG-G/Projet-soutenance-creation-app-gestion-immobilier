<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BienController extends Controller
{
    public function index()
    {
        $biens = Bien::with(['proprietaire', 'ville', 'typeBien', 'photos'])->get();
        return response()->json($biens);
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'surface' => 'required|integer',
            'adresse' => 'required|string|max:255',
            'statut' => 'required|in:disponible,vendu,loue',
            'proprietaire_id' => 'required|exists:proprietaires,id',
            'ville_id' => 'required|exists:villes,id',
            'type_bien_id' => 'required|exists:types_biens,id',
        ]);

        $bien = Bien::create($request->all());

        return response()->json($bien, 201);
    }


    public function show(Bien $bien)
    {
        $bien->load(['proprietaire', 'ville', 'typeBien', 'photos']);
        return response()->json($bien);
    }

    public function update(Request $request, Bien $bien)
    {
        try {
            $validated = $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'prix' => 'required|numeric',
                'surface' => 'required|integer',
                'adresse' => 'required|string|max:255',
                'statut' => 'required|in:disponible,vendu,loue',
                'proprietaire_id' => 'required|exists:proprietaires,id',
                'ville_id' => 'required|exists:villes,id',
                'type_bien_id' => 'required|exists:types_biens,id',
            ]);
            $bien->update($validated);
            return response()->json($bien);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors(), 'message' => 'Validation error'], 422);
        } catch (\Exception $e) {
            // \Log::error('Erreur update bien', ['exception' => $e, 'input' => $request->all()]);
            return response()->json(['message' => 'Erreur serveur', 'error' => $e->getMessage()], 500);
        }
    }


    public function destroy(Bien $bien)
    {
        $bien->delete();
        return response()->json(null, 204);
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $biens = Bien::with(['ville', 'typeBien'])
                     ->where('titre', 'like', "%$query%")
                     ->orWhereHas('ville', fn($q) => $q->where('nom', 'like', "%$query%"))
                     ->orWhereHas('typeBien', fn($q) => $q->where('nom', 'like', "%$query%"))
                     ->orWhere('statut', 'like', "%$query%")
                     ->get();
        return response()->json($biens);
    }
}