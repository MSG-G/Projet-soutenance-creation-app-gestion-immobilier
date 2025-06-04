<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function reservationsAsClient()
    {
        return $this->hasMany(Reservation::class, 'client_id');
    }

    public function reservationsAsAgent()
    {
        return $this->hasMany(Reservation::class, 'agent_id');
    }

    public function contratsAsClient()
    {
        return $this->hasMany(Contrat::class, 'client_id');
    }

    public function contratsAsAgent()
    {
        return $this->hasMany(Contrat::class, 'agent_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'expediteur_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'destinataire_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
