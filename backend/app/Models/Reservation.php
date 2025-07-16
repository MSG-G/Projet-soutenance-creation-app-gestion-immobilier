<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_visite', 'etat', 'bien_id', 'client_id', 'agent_id',
        'nom', 'email', 'telephone', 'message'
    ];

    

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }
}