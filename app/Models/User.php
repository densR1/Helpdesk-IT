<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    // Tambahin relationship
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    public function isAgent()
    {
        return $this->role->name === 'agent';
    }

    public function isUser()
    {
        return $this->role->name === 'user';
    }
}
