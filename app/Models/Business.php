<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $table = 'businesses';

    protected $fillable = [
        'user_id',
        'business_name',
        'gst_number',
        'service_id',
        'year',
        'start_time',
        'end_time',
        'amenities',
        'website',
        'people_search',
        'description',
        'images',
        'status',
        'deleted_at',
    ];

    protected $appends = ['rating','review'];
    // protected $casts = [
    //     'start_time' => 'datetime:H:i',
    //     'end_time' => 'datetime:H:i',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        // return $this->belongsTo(Services::class, 'service_id');
        return $this->belongsToMany(Services::class, 'businesses_services');
    }

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->user_id = isset(auth()->user()->id) ? auth()->user()->id : 0;
    //     });
    // }

    public function enquiry()
    {
        return $this->hasMany(Enquiry::class, 'business_id');
    }

    public function ratingReview()
    {
        return $this->hasMany(BusinessRatingReview::class)->select('id','business_id','user_id','rating','review');
    }

    public function getRatingAttribute(){
       $avg =  $this->hasMany(BusinessRatingReview::class)->avg('rating');
       return $avg ? number_format($avg, 2):0;
    }

    public function getReviewAttribute(){
        return $this->hasMany(BusinessRatingReview::class)->count('review');
    }
}
