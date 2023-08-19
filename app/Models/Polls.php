<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Polls extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'image',
        'description',
        'deleted_at'
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset(Storage::url($this->image)) : '';
    }
}
