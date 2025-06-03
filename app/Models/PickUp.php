<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pickup extends Model
{
    protected $table = 'pick_ups';
    protected $primaryKey = 'pick_up_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'user_id',
        'start_time',
        'pick_up_date',
        'arrival_date',
        'photos',
        'notes',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

