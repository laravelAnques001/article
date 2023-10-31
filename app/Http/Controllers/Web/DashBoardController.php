<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\Article;
use App\Models\Business;
use App\Models\Services;
use App\Models\SubscriptionPlan;
use App\Models\User;

class DashBoardController extends Controller
{
    public function dashboard()
    {
        $article = Article::selectRaw('status, COUNT(*) as count')->whereNull('deleted_at')->groupBy('status')->pluck('count', 'status')->toArray();
        $articleTotal = collect($article)->sum();

        $advertise = Advertise::selectRaw('status, COUNT(*) as count')->whereNull('deleted_at')->groupBy('status')->pluck('count', 'status')->toArray();
        $advertiseTotal = collect($advertise)->sum();

        $subscriptionPlan = SubscriptionPlan::selectRaw('status, COUNT(*) as count')->whereNull('deleted_at')->groupBy('status')->pluck('count', 'status')->toArray();
        $subscriptionPlanTotal = collect($subscriptionPlan)->sum();

        $services = Services::selectRaw('status, COUNT(*) as count')->whereNull('deleted_at')->groupBy('status')->pluck('count', 'status')->toArray();
        $servicesTotal = collect($services)->sum();

        $business = Business::selectRaw('status, COUNT(*) as count')->whereNull('deleted_at')->groupBy('status')->pluck('count', 'status')->toArray();
        $businessTotal = collect($business)->sum();

        $userActive = User::where('is_admin', 0)->whereNull('deleted_at')->count();
        $userRemove = User::where('is_admin', 0)->whereNotNull('deleted_at')->count();
        $userTotal = $userActive + $userRemove;

        return view('Admin.dashboard', compact('article', 'articleTotal', 'advertise', 'advertiseTotal', 'subscriptionPlan', 'subscriptionPlanTotal', 'services', 'servicesTotal', 'business', 'businessTotal', 'userActive', 'userRemove', 'userTotal'));
    }
}
