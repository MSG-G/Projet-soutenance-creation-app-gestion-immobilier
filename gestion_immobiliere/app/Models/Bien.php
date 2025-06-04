<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'prix',
        'type', // vente, location
        'surface',
        'adresse',
        'ville_id',
        'proprietaire_id',
        'type_bien_id',
    ];

    public function proprietaire()
    {
        return $this->belongsTo(Proprietaire::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function typeBien()
    {
        return $this->belongsTo(TypeBien::class, 'type_bien_id');
    }

    public function visites()
    {
        return $this->hasMany(Visite::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
