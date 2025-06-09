<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bien;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Biens",
 *     description="API Endpoints pour la gestion des biens immobiliers"
 * )
 */
class BienController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/biens",
     *     summary="Liste tous les biens immobiliers",
     *     tags={"Biens"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des biens immobiliers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="titre", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="prix", type="number"),
     *                 @OA\Property(property="adresse", type="string"),
     *                 @OA\Property(property="ville_id", type="integer"),
     *                 @OA\Property(property="type_bien_id", type="integer"),
     *                 @OA\Property(property="proprietaire_id", type="integer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $biens = Bien::with(['proprietaire', 'ville', 'typeBien'])->get();
        return response()->json($biens);
    }

    /**
     * @OA\Post(
     *     path="/api/biens",
     *     summary="Crée un nouveau bien immobilier",
     *     tags={"Biens"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titre", "description", "prix", "adresse", "ville_id", "type_bien_id", "proprietaire_id"},
     *             @OA\Property(property="titre", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="prix", type="number"),
     *             @OA\Property(property="adresse", type="string"),
     *             @OA\Property(property="ville_id", type="integer"),
     *             @OA\Property(property="type_bien_id", type="integer"),
     *             @OA\Property(property="proprietaire_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Bien immobilier créé avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     )
     * )
     */
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
            'type_bien_id' => 'required|exists:types_bien,id',
        ]);

        $bien = Bien::create($request->all());

        return response()->json($bien, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/biens/{id}",
     *     summary="Affiche les détails d'un bien immobilier",
     *     tags={"Biens"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du bien immobilier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du bien immobilier"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bien immobilier non trouvé"
     *     )
     * )
     */
    public function show(Bien $bien)
    {
        $bien->load(['proprietaire', 'ville', 'typeBien']);
        return response()->json($bien);
    }

    /**
     * @OA\Put(
     *     path="/api/biens/{id}",
     *     summary="Met à jour un bien immobilier",
     *     tags={"Biens"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du bien immobilier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="titre", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="prix", type="number"),
     *             @OA\Property(property="adresse", type="string"),
     *             @OA\Property(property="ville_id", type="integer"),
     *             @OA\Property(property="type_bien_id", type="integer"),
     *             @OA\Property(property="proprietaire_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bien immobilier mis à jour avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bien immobilier non trouvé"
     *     )
     * )
     */
    public function update(Request $request, Bien $bien)
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
            'type_bien_id' => 'required|exists:types_bien,id',
        ]);

        $bien->update($request->all());

        return response()->json($bien);
    }

    /**
     * @OA\Delete(
     *     path="/api/biens/{id}",
     *     summary="Supprime un bien immobilier",
     *     tags={"Biens"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du bien immobilier",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bien immobilier supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bien immobilier non trouvé"
     *     )
     * )
     */
    public function destroy(Bien $bien)
    {
        $bien->delete();
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/api/biens/search",
     *     summary="Recherche des biens immobiliers",
     *     tags={"Biens"},
     *     @OA\Parameter(
     *         name="q",
     *         in="query",
     *         description="Terme de recherche",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Résultats de la recherche"
     *     )
     * )
     */
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