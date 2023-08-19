<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    use HasFactory;

    protected $fillable = [
        'target',
        'latitude',
        'longitude',
        'budget',
        'start_date',
        'end_date',
        'deleted_at',
    ];
}
