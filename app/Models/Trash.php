<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trash extends Model
{
    use HasFactory;

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
}
