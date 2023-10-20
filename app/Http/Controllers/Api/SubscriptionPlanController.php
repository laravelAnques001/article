<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPlanPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                ->get();
        } else {
            $subscriptionPlan = SubscriptionPlan::select('id', 'name', 'time_period', 'price', 'description', 'status')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->get();
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

    public function subscriptionPlanPurchase(Request $request)
    {
        $validated = $request->all();
        $validator = Validator::make($validated, [
            'business_id' => 'required|exists:businesses,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'payment_response' => 'required|string',
            'transaction_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        SubscriptionPlanPurchase::create($validated);
        return $this->sendResponse([], 'Subscription Plan Purchase Record Store SuccessFully.');
    }

    public function subscriptionPlanHistory()
    {
        $spHistory = SubscriptionPlanPurchase::select('id', 'subscription_plan_id', 'business_id', 'transaction_id', 'payment_response')
            ->with(['subscriptionPlan' => function ($q) {
                $q->select('id', 'name', 'time_period', 'price', 'description', 'status');
            }])
            ->with(['business' => function ($q) {
                $q->select('id', 'business_name');
            }])
            ->whereHas('business', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->whereNull('deleted_at')
            ->get();

        return $this->sendResponse($spHistory, 'Subscription Plan History Get SuccessFully.');
    }
}
