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

    // ✅ Hanya log ketika ada perubahan data (dirty attributes)
    protected static $logOnlyDirty = true;

    // ✅ Nama untuk log yang dicatat
    protected static $logName = 'update';

    // ✅ Atribut yang dicatat jika berubah
    protected static $logAttributes = [
        'address',
        'province',
        'city',
        'postal_code',
        'balance'
    ];

    // ✅ Hindari pencatatan log jika tidak ada perubahan (di luar logOnlyDirty)
    protected static function booted()
    {
        static::updating(function ($model) {
            // Jangan log jika tidak ada atribut yang berubah
            if (!$model->isDirty(self::$logAttributes)) {
                activity()->disableLogging();
            }
        });

        static::updated(function ($model) {
            activity()->enableLogging();
        });
    }

    /**
     * Deskripsi untuk log perubahan.
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "User dengan ID {$this->getKey()} mengubah data tambahan: {$eventName}.";
    }

    /**
     * Opsi logging dari spatie.
     */
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

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
