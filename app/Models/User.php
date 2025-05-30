<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    // fitur chat
    /**
     * Get all chats where this user is involved
     */
    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'chat_details', 'user_id', 'chat_id');
    }

    /**
     * Get all messages sent by this user
     */
    public function messages()
    {
        return $this->hasMany(ChatDetail::class, 'user_id');
    }

    /**
     * Check if user is a driver
     */
    public function isDriver()
    {
        return $this->role === 3;
    }

    /**
     * Check if user is a regular user (not admin/driver)
     */
    public function isRegularUser()
    {
        return $this->role === 1;
    }

    /**
     * Get the driver's license information
     */
    public function license()
    {
        return $this->hasOne(UserLicense::class, 'user_id');
    }
}
