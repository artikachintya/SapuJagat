<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $primaryKey = 'chat_id';
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
}
