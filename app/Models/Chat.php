<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    // protected $primaryKey = 'chat_id';
    // public $timestamps = false;

    use HasFactory;

    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'driver_id',
        'date_time_created',
    ];

    public function details()
    {
        return $this->hasMany(ChatDetail::class, 'chat_id', 'chat_id');
    }
    public function users()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
    public function drivers()
    {
        return $this->hasOne(User::class, 'user_id', 'driver_id');
    }

    // relasi ke user (pengirim pesan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // relasi ke driver
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'user_id');
    }
    // tombol back
    // app/Models/Chat.php
    // Chat.php
    // public function pickup()
    // {
    //     return $this->belongsTo(\App\Models\PickUp::class, 'pick_up_id');
    // }
}
