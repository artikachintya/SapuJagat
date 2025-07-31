<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Penugasan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'penugasans';
    protected $primaryKey = 'penugasan_id';
    public $incrementing = true;
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    protected $fillable = ['order_id', 'user_id', 'created_at', 'status'];

    public function getRouteKeyName()
    {
        return 'penugasan_id';
    }

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('order_id', $this->order_id)
            ->where('user_id', $this->user_id)
            ->where('created_at', $this->created_at);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    protected static function booted()
    {
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            static::creating(function () {
                activity()->disableLogging();
            });
            static::created(function () {
                activity()->enableLogging();
            });
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('assignment_activity')
            ->logOnly(['order_id', 'user_id'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function (string $eventName) {
                $adminName = auth()->check() ? auth()->user()->name : 'Sistem';
                return "Penugasan {$eventName} oleh {$adminName} ke Order ID {$this->order_id} dengan Driver ID {$this->user_id}";
            });
    }
}
