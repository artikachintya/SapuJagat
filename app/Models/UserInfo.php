<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class UserInfo extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'users_info';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected static $logOnlyDirty = true;
    protected static $logName = 'update';

    protected static $logAttributes = [
        'address',
        'province',
        'city',
        'postal_code',
        'balance'
    ];

    protected static function booted()
    {
        // Nonaktifkan logging saat dijalankan dari seeder atau factory
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            static::creating(function () {
                activity()->disableLogging();
            });

            static::created(function () {
                activity()->enableLogging();
            });

            static::updating(function () {
                activity()->disableLogging();
            });

            static::updated(function () {
                activity()->enableLogging();
            });

            return; // hentikan listener di bawah ini saat di console
        }

        // Listener normal saat berjalan bukan di CLI
        static::updating(function ($model) {
            if (!$model->isDirty(self::$logAttributes)) {
                activity()->disableLogging();
            }
        });

        static::updated(function () {
            activity()->enableLogging();
        });
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User dengan ID {$this->getKey()} mengubah data tambahan: {$eventName}.";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(self::$logAttributes)
            ->logOnlyDirty()
            ->useLogName(self::$logName);
    }

    protected $fillable = [
        'user_id',
        'address',
        'province',
        'city',
        'postal_code',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
