<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = ['date_debut', 'date_fin', 'montant', 'type', 'client_id', 'agent_id', 'bien_id'];

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