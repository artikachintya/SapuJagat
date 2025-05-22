<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatDetail extends Model
{
    // protected $table = 'chat_details';
    // protected $primaryKey = 'chatdetail_id';
    // // protected $primaryKey = 'ud_id';
    // public $timestamps = false;

    // protected $fillable = [
    //     'chat_id',
    //     'detail_chat',
    //     'photos',
    //     'date_time',
    // ];

    // public function chat(): BelongsTo
    // {
    //     return $this->belongsTo(Chat::class, 'chat_id', 'chat_id');
    // }
    protected $table = 'chat_details';
    protected $primaryKey = 'chatdetail_id';
    public $timestamps = false;

    protected $fillable = [
        'chat_id',
        'user_id',
        'driver_id',
        'detail_chat',
        'photos',
        'date_time',
    ];

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }
}
