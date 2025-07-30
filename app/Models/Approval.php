<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;

class Approval extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = false;
    protected $table = 'approvals';
    protected $primaryKey = 'approval_id';

    protected $fillable = [
        'order_id',
        'user_id',
        'date_time',
        'approval_status',
        'notes',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
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
            ->useLogName('approval_activity')
            ->logOnly(['approval_status', 'notes'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function (string $eventName) {
                $status = $this->getStatusString($this->approval_status);
                $user = Auth::user();
                $userRole = $this->getRoleName($user->role ?? null);
                $userName = $user->name ?? 'Pengguna';

                return ucfirst($userRole) . " {$userName} {$status} Order ID {$this->order_id}";
            });
    }

    private function getStatusString($status): string
    {
        return match ((int) $status) {
            0 => 'menolak',
            1 => 'menyetujui',
            2 => 'menunda',
        };
    }

    private function getRoleName($role): string
    {
        return match ((int) $role) {
            1 => 'pengguna',
            2 => 'admin',
            3 => 'driver',
            default => 'pengguna',
        };
    }
}
