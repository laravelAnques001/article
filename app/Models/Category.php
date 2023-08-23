<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'image',
        'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? (config('app.azure').'/uploads/readwave/'.$this->image) :asset('assets/images/McrkmG7D6RoKVN7k42ojo4mMeN6WM7uZ5RmhUoeM.jpg');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function article()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
