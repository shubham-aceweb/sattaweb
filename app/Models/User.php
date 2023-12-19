<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
        'status',
        'created_at',
        'updated_at',
    ];
     protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
