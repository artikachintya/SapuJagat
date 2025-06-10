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

    protected $casts = [
        'date_time' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Add this to your ChatDetail model
    public function getTimeAttribute()
    {
        return $this->date_time->format('H:i');
    }

     // Di model Chat
    public function details()
    {
        return $this->hasMany(ChatDetail::class, 'chat_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
