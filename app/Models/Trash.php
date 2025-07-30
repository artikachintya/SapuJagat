<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Trash extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $primaryKey = 'trash_id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'type',
        'price_per_kg',
        'max_weight',
        'photos',
    ];

    protected $dates = ['deleted_at'];

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
            ->useLogName('trash_activity')
            ->logOnly(['name', 'type', 'price_per_kg', 'max_weight', 'photos'])
            ->logOnlyDirty() // hanya log jika field-nya berubah
            ->setDescriptionForEvent(fn(string $eventName) => "Sampah berhadil di {$eventName}");
    }
}
