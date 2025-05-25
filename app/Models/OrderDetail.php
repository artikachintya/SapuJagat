<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    public $timestamps = false;
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'trash_id',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function trash()
    {
        return $this->belongsTo(Trash::class, 'trash_id');
    }
}
