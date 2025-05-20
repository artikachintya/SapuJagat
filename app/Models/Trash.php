<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trash extends Model
{
    use HasFactory;

    protected $primaryKey = 'trash_id';

    protected $fillable = [
        'name',
        'type',
        'price_per_kg',
        'max_weight',
    ];

    public $timestamps = false; // karena tidak ada created_at & updated_at
}

