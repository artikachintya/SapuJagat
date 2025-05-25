<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

<<<<<<< HEAD
    // Mengatur nama kolom primary key dan tipe datanya
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

=======
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
>>>>>>> a75241f85fd1a6e57c9599b652bb64d78664ae1f
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'NIK',
        'email',
        'phone_num',
        'password',
        'status',
        'role',
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
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }
}
