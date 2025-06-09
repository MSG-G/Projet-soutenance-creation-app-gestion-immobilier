<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
            'bien_id' => 'required|exists:biens,id',
        ]);

        $photo = Photo::create($request->all());
        return response()->json($photo, 201);
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return response()->json(null, 204);
    }
    
}