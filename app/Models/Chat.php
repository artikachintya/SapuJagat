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
        'date_time_created',
    ];

    public function details()
    {
        return $this->hasMany(ChatDetail::class, 'chat_id');
    }
}
