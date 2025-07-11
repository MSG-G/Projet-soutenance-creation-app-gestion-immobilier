<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['client', 'agent', 'bien'])->get();
        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_visite' => 'required|date',
            'etat' => 'required|in:planifiee,confirmee,annulee',
            'client_id' => 'required|exists:users,id',
            'agent_id' => 'required|exists:users,id',
            'bien_id' => 'required|exists:biens,id',
        ]);

        $reservation = Reservation::create($request->all());

        Notification::create([
            'message' => 'Nouvelle réservation pour le bien #' . $reservation->bien_id,
            'user_id' => $reservation->agent_id,
        ]);

        return response()->json($reservation, 201);
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['client', 'agent', 'bien']);
        return response()->json($reservation);
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

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json(null, 204);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $reservations = Reservation::with(['bien'])
                                   ->where('etat', 'like', "%$query%")
                                   ->orWhereHas('bien', fn($q) => $q->where('titre', 'like', "%$query%"))
                                   ->get();
        return response()->json($reservations);
    }
}
```