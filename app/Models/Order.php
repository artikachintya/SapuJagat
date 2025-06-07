<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use SebastianBergmann\CodeCoverage\Driver\Driver;
class Order extends Model
{
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'date_time_request',
        'pickup_time',
        'photo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function pickup()
    {
        return $this->hasOne(Pickup::class, 'order_id', 'order_id');
    }

    public function approval()
    {
        return $this->hasOne(Approval::class, 'order_id');
    }


    public function formattedDateTime($relation, $field)
    {
        if ($this->$relation && $this->$relation->$field) {
            return \Carbon\Carbon::parse($this->$relation->$field)->format('d M Y - H.i') . ' WIB';
        }
        return '-';
    }

    // Tambahkan relasi ke driver jika belum ada
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id', 'user_id');

    }
}



