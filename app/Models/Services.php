<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = [
        'title',
        'company_name',
        'location',
        'image',
        'description',
        'status',
        'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? (config('app.azure') . '/uploads/readwave/' . $this->image) : asset('assets/images/McrkmG7D6RoKVN7k42ojo4mMeN6WM7uZ5RmhUoeM.jpg');
    }

    public function business()
    {
        // return $this->hasMany(Business::class,'service_id');
        return $this->belongsToMany(Business::class,'businesses_services');
    }
}
