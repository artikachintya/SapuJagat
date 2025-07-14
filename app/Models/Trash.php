<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trash extends Model
{
    use HasFactory, SoftDeletes;

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

    protected $dates = ['deleted_at']; // ini bisa opsional di Laravel 10+
}

