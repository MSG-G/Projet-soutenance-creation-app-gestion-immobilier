<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contrat;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContratController extends Controller
{
    public function index()
    {
        $contrats = Contrat::with(['bien', 'client', 'agent'])->latest()->get();
        return response()->json($contrats);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bien_id' => 'required|exists:biens,id',
            'client_id' => 'required|exists:users,id',
            'agent_id' => 'required|exists:users,id',
            'type' => 'required|in:vente,location',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $contrat = Contrat::create($request->all());

        // Mettre à jour le statut du bien
        $bien = Bien::find($request->bien_id);
        if ($bien) {
            if ($request->type === 'vente') {
                $bien->statut = 'vendu';
            } elseif ($request->type === 'location') {
                $bien->statut = 'loué';
            }
            $bien->save();
        }

        return response()->json(Contrat::with(['bien', 'client', 'agent'])->find($contrat->id), 201);
    }

    public function show(Contrat $contrat)
    {
        return response()->json($contrat->load(['bien', 'client', 'agent']));
    }

    public function update(Request $request, Contrat $contrat)
    {
        $validator = Validator::make($request->all(), [
            'bien_id' => 'sometimes|required|exists:biens,id',
            'client_id' => 'sometimes|required|exists:users,id',
            'agent_id' => 'sometimes|required|exists:users,id',
            'type' => 'sometimes|required|in:vente,location',
            'montant' => 'sometimes|required|numeric|min:0',
            'date_debut' => 'sometimes|required|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $contrat->update($request->all());

        return response()->json($contrat->load(['bien', 'client', 'agent']));
    }

    public function destroy(Contrat $contrat)
    {
        $contrat->delete();
        return response()->json(null, 204);
    }
}
