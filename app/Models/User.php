<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\CustomResetPassword;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected static $logOnlyDirty = true; // Hanya log jika nilai berubah
    protected static $logName = 'user_activity';

    protected static $logAttributes = [
        'name',
        'NIK',
        'email',
        'phone_num',
        'profile_pic'
    ];

    protected static function booted()
    {
        // Nonaktifkan logging saat seeder/factory berjalan
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            static::creating(function () {
                activity()->disableLogging();
            });
            static::created(function () {
                activity()->enableLogging();
            });
        }

        static::updating(function ($model) {
            if (!$model->isDirty(self::$logAttributes)) {
                activity()->disableLogging();
            }
        });

        static::updated(function ($model) {
            activity()->enableLogging();
        });
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User dengan ID {$this->getKey()} melakukan {$eventName} pada akun.";
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
        'name',
        'NIK',
        'email',
        'phone_num',
        'password',
        'profile_pic',
        'status',
        'role',
        'remember_token',
        'is_google_user',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function pickup()
    {
        return $this->hasMany(Pickup::class, 'user_id');
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'user_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(ChatDetail::class, 'user_id');
    }

    public function license()
    {
        return $this->hasOne(UserLicense::class, 'user_id', 'user_id');
    }
}
