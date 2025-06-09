<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'name',
        'NIK',
        'email',
        'phone_num',
        'password',
        'profile_pic',
        'status',
        'role',
        'remember_token',
        'is_google_user',
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


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'user_id');
    }

    // Di model User
    public function sentMessages()
    {
        return $this->hasMany(ChatDetail::class, 'user_id');
    }

    public function license()
    {
         return $this->hasOne(UserLicense::class, 'user_id', 'user_id');
    }
}
