<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Response extends Model
{
    // Gunakan kedua trait ini
    use HasFactory, LogsActivity;

    /**
     * Karena tabel tidak memiliki primary key, kita perlu menonaktifkan
     * beberapa fitur default Eloquent untuk menghindari error.
     * * @var string|null
     */
    protected $primaryKey = null; // Eksplisit menyatakan tidak ada primary key

    /**
     * Menunjukkan jika model tidak memiliki primary key yang auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Menunjukkan jika model tidak menggunakan timestamps (created_at, updated_at).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'report_id',
        'response_message',
        'date_time_response',
    ];

    /**
     * Mendefinisikan opsi untuk activity log.
     * * @return \Spatie\Activitylog\LogOptions
     */

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
            ->useLogName('response_activity')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(function (string $eventName) {
                $admin = auth()->user()?->name ?? 'Guest';
                return "Respons laporan {$eventName} oleh {$admin}";
            })
            ->dontSubmitEmptyLogs();
    }

    /**
     * Mendapatkan user yang terkait dengan response.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mendapatkan report yang terkait dengan response.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}