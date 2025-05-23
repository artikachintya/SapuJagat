<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->user_id) {
                $lastUser = self::orderBy('user_id', 'desc')->first();

                // Ambil angka terakhir dari ID, misal "U009" => 9
                $lastId = $lastUser ? intval(substr($lastUser->user_id, 1)) : 0;

                // Buat ID baru, misal 10 => "U010"
                $user->user_id = 'U' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }
    
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'user_id',
        'name',
        'NIK',
        'email',
        'address',
        'province',
        'city',
        'postal_code',
        'phone_num',
        'password',
        'status',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
