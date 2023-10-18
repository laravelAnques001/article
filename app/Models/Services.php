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
        'short_description',
        'description',
        'status',
        'deleted_at',
    ];

    protected $appends = [
        'image_url',
        'is_applied',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? (config('app.azure') . '/uploads/readwave/' . $this->image) : asset('assets/images/McrkmG7D6RoKVN7k42ojo4mMeN6WM7uZ5RmhUoeM.jpg');
    }

    public function business()
    {
        // return $this->hasMany(Business::class,'service_id');
        return $this->belongsToMany(Business::class, 'businesses_services');
    }

    public function serviceApply()
    {
        return $this->hasMany(ServiceApply::class, 'service_id');
    }

    public function getIsAppliedAttribute()
    {
        return $this->serviceApply()->where('user_id', auth()->id())->first() ? true : false;
    }
}
