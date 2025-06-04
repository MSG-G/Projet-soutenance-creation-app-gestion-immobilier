<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'contrat_id',
        'user_id',
        'montant',
        'date_transaction',
        'type_paiement', // carte, espèces, virement
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

