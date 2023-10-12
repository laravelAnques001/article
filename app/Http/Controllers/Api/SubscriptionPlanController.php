<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPlanPurchaseRequests;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPlanPurchase;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index(Request $request)
    {
        $search = isset($request->search) ? $request->search : null;
        if ($search) {
            $subscriptionPlan = SubscriptionPlan::select('id', 'name', 'time_period', 'price', 'description', 'status')
                ->where('time_period', 'like', '%' . $search . '%')
                ->orWhere('price', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $subscriptionPlan = SubscriptionPlan::select('id', 'name', 'time_period', 'price', 'description', 'status')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->paginate(10);
        }
        return $this->sendResponse($subscriptionPlan, 'Subscription Plan List Get Successfully.');
    }

    public function show($id)
    {
        $subscriptionPlan = SubscriptionPlan::select('id', 'name', 'time_period', 'price', 'description', 'status')
            ->whereNull('deleted_at')
            ->where('status', 'Active')
            ->find(base64_decode($id));
        if ($subscriptionPlan) {
            return $this->sendResponse($subscriptionPlan, 'Subscription Plan Record Show SuccessFully.');
        }
        return $this->sendError('Record Not Found.');
    }

    public function subscriptionPlanPurchase(SubscriptionPlanPurchaseRequests $request)
    {
        $validated = $request->validated();
        SubscriptionPlanPurchase::create($validated);
        return $this->sendResponse([], 'Subscription Plan Purchase Record Store SuccessFully.');
    }
}
