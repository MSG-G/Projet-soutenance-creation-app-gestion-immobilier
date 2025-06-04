<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['chemin_photo', 'bien_id'];

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}
