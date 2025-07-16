<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'description', 'prix', 'surface', 'adresse', 'statut',
        'proprietaire_id', 'ville_id', 'type_bien_id',
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
        return $this->belongsTo(TypeBien::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
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