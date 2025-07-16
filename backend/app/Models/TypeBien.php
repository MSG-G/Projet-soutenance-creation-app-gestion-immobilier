<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBien extends Model
{
    use HasFactory;
    
    protected $table = 'types_biens';

    protected $fillable = [
        'nom',
        'description'
    ];

    public function biens()
    {
        return $this->hasMany(Bien::class);
    }
}