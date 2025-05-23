<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Approval extends Model
{
    public $timestamps = false;
    protected $table = 'approvals';

    protected $fillable = [
        'order_id',
        'date_time',
        'approval_status',
        'notes',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
