<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['client', 'agent', 'bien'])->get();
        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        
    $validatedData = $request->validate([
        'bien_id' => 'required|exists:biens,id',
        'date_visite' => 'required|date',
        'message' => 'nullable|string',
    ]);

    $client = $request->user();

    // Assigne un agent disponible (par exemple, le premier trouvé)
    $agent = User::where('role', 'agent')->first();

    if (!$agent) {
        return response()->json(['message' => 'Aucun agent disponible pour le moment.'], 500);
    }

    $reservation = Reservation::create([
        'bien_id' => $validatedData['bien_id'],
        'date_visite' => $validatedData['date_visite'],
        'message' => $validatedData['message'],
        'client_id' => $client->id,
        'agent_id' => $agent->id,
        'etat' => 'planifiee',
        // Les infos client sont dans la relation, plus besoin de les stocker ici
        'nom' => $client->name,
        'email' => $client->email,
        'telephone' => $client->phone,
    ]);

    // On recharge le bien pour être sûr d'avoir le titre
    $bien = \App\Models\Bien::find($validatedData['bien_id']);

    Notification::create([
        'message' => 'Nouvelle demande de visite pour ' . ($bien ? $bien->titre : 'un bien') . ' par ' . $client->name,
        'user_id' => $agent->id,
    ]);

    return response()->json($reservation, 201);
        
}
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'date_visite' => 'required|date',
            'etat' => 'required|in:planifiee,confirmee,annulee',
            'client_id' => 'required|exists:users,id',
            'agent_id' => 'required|exists:users,id',
            'bien_id' => 'required|exists:biens,id',
        ]);

        $reservation->update($request->all());

        return response()->json($reservation);
    }

    /**
     * Met à jour uniquement la colonne etat (planifiee/confirmee/annulee).
     */
    public function updateEtat(Request $request, Reservation $reservation)
    {
        $request->validate([
            'etat' => 'required|in:planifiee,confirmee,annulee',
        ]);

        $reservation->update(['etat' => $request->etat]);

        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(null, 204);
    }

    public function clientReservations()
    {
        $client = request()->user();
        $reservations = Reservation::with(['bien.photos'])
            ->where('client_id', $client->id)
            ->orderByDesc('created_at')
            ->get();
        return response()->json($reservations);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $reservations = Reservation::with(['bien.photos'])
                                   ->where('etat', 'like', "%$query%")
                                   ->orWhereHas('bien', fn($q) => $q->where('titre', 'like', "%$query%"))
                                   ->get();
        return response()->json($reservations);
    }
}