<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatDetail extends Model
{
    protected $primaryKey = 'chat_detail_id';
    public $timestamps = false;

    protected $fillable = [
        'chat_id',
        'user_id',
        'detail_chat',
        'photos',
        'date_time',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
