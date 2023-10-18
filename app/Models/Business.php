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
        'location',
        'contact_number',
        'deleted_at',
    ];

    protected $appends = ['rating', 'review', 'old_years', 'web_link', 'image_list', 'is_promoted', 'promoted_tag'];
    // protected $casts = [
    //     'start_time' => 'datetime:H:i',
    //     'end_time' => 'datetime:H:i',
    // ];

    protected $casts = [
        'contact_number' => 'string',
        'year' => 'string',
    ];

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
        return $this->hasMany(BusinessRatingReview::class)->select('id', 'business_id', 'user_id', 'rating', 'review');
    }

    public function getRatingAttribute()
    {
        $avg = $this->hasMany(BusinessRatingReview::class)->avg('rating');
        return $avg ? (float) number_format($avg, 2) : 0;
    }

    public function getReviewAttribute()
    {
        return $this->hasMany(BusinessRatingReview::class)->count('review');
    }

    public function getOldYearsAttribute()
    {
        return $this->year ? (date('Y') - $this->year) . ' years in Business' : null;
    }

    public function getWebLinkAttribute()
    {
        return route('businessView', base64_encode($this->id));
    }

    // public function getContactNumberAttribute()
    // {
    //     return (string) $this->contact_number;
    // }

    public function subscriptionPlan()
    {
        return $this->hasOne(SubscriptionPlanPurchase::class, 'business_id');
    }

    // public function getSubscriptionPlanDate()
    // {
    //     // return $this->servicePurchase->latest();
    // }

    public function getImageListAttribute()
    {
        return $this->images ? explode(',', $this->images) : [];
    }

    public function aminity()
    {
        return $this->belongsToMany(Aminity::class, 'aminities_businesses');
    }

    public function getIsPromotedAttribute()
    {
        return false;
    }

    public function getPromotedTagAttribute()
    {
        return 'Top Rated';
    }

}
