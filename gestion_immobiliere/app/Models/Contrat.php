<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    protected $fillable = [
        'bien_id',
        'type', // vente ou location
        'date_signature',
        'pdf_path',
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
