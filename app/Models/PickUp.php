<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PickUp extends Model
{
    protected $table = 'pick_ups';
    protected $primaryKey = 'pick_up_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'driver_id',
        'pick_up_date',
        'arrival_date',
        'photos',
        'notes',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }
}
