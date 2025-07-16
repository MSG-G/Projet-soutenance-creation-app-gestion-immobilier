<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'bien_id' => 'required|exists:biens,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('photos', 'public');
            $url = asset('storage/' . $path);
        } else {
            return response()->json(['error' => 'Aucune image uploadée'], 422);
        }

        $photo = Photo::create([
            'url' => $url,
            'bien_id' => $request->bien_id,
        ]);

        return response()->json($photo, 201);
    }

    public function destroy(Photo $photo)
    {
        // Supprimer le fichier physique si présent
        if ($photo->url) {
            $path = str_replace(asset('storage') . '/', '', $photo->url);
            Storage::disk('public')->delete($path);
        }
        $photo->delete();
        return response()->json(null, 204);
    }
    
}