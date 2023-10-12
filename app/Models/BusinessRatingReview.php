<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRatingReview extends Model
{
    use HasFactory;
    protected $table = 'business_rating_reviews';

    protected $fillable = [
        'business_id',
        'user_id',
        'rating',
        'review',
        'deleted_at',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class,'business_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->user_id = isset(auth()->user()->id) ? auth()->user()->id : 0;
    //     });
    // }
}
