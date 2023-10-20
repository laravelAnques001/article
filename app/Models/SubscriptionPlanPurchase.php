<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlanPurchase extends Model
{
    use HasFactory;

    protected $table = 'subscription_plan_purchases';

    protected $fillable = [
        'subscription_plan_id',
        'business_id',
        'payment_response',
        'transaction_id',
        'deleted_at',
    ];

    protected $appends = ['expiry_date', 'is_expired'];

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function getExpiryDateAttribute()
    {
        $time_period = $this->subscriptionPlan->time_period;
        if ($time_period == 'Monthly') {
            return Carbon::parse($this->created_at)->addMonths(1)->format('Y-m-d');
        } elseif ($time_period == 'Yearly') {
            return Carbon::parse($this->created_at)->addYears(1)->format('Y-m-d');
        }
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date < now()->format('Y-m-d') ? true : false;
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

}
