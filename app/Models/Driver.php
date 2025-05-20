<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // kalau admin login
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'driver_id'; // sesuai migration

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'license_plate',
    ];

    protected $hidden = [
        'password',
    ];
}
