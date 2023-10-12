<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanPurchase extends Model
{
    use HasFactory;

    protected $table = 'subscription_plan_purchases';

    protected $fillable = [
        'service_id',
        'business_id',
        'payment_response',
        'deleted_at',
    ];

    public function service()
    {
        return $this->belongsTo(Services::class,'service_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class,'business_id');
    }
}
