<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penugasan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'penugasans';          // pivot table name
    protected $primaryKey = 'penugasan_id';
    public $incrementing = true; // default, should be true
    public $timestamps  = false;              // we keep created_at manually
    protected $dates = ['deleted_at'];
    
    // OPTIONAL: Mass‑assignable fields
    protected $fillable = ['order_id', 'user_id', 'created_at',
        'status',];

    /**
     * Override save query for composite key (order_id, user_id, created_at)
     * so update() calls work.
     */
    public function getRouteKeyName()
    {
        return 'penugasan_id';
    }
    protected function setKeysForSaveQuery($query)
    {
        return $query->where('order_id', $this->order_id)
                     ->where('user_id',  $this->user_id)
                     ->where('created_at', $this->created_at);
    }

    /* Relationships back to Order / User (optional) */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
