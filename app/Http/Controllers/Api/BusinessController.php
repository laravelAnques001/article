<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRatingReviewRequest;
use App\Http\Requests\BusinessRequest;
use App\Models\Business;
use App\Models\BusinessRatingReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = isset($request->search) ? $request->search : null;
        $my_business = isset($request->my_business) ? auth()->id() : null;
        if ($search) {
            $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'amenities', 'website', 'people_search', 'description', 'images', 'status')
                ->with(['user' => function ($q) use ($search) {
                    $q->select('id', 'name', 'email', 'image');
                    $q->where('name', 'like', '%' . $search . '%');
                    $q->orWhere('email', 'like', '%' . $search . '%');
                }])
                ->with(['service' => function ($q) use ($search) {
                    $q->select('id', 'title', 'company_name');
                    $q->where('title', 'like', '%' . $search . '%');
                    $q->orWhere('company_name', 'like', '%' . $search . '%');
                }])
                ->where('business_name', 'like', '%' . $search . '%')
                ->orWhere('gst_number', 'like', '%' . $search . '%')
                ->orWhere('year', 'like', '%' . $search . '%')
                ->orWhere('start_time', 'like', '%' . $search . '%')
                ->orWhere('end_time', 'like', '%' . $search . '%')
                ->orWhere('website', 'like', '%' . $search . '%')
                ->orWhere('people_search', 'like', '%' . $search . '%')
                ->when($my_business, function ($q) use ($my_business) {
                    $q->where('user_id', $my_business);
                })
                ->when(!$my_business, function ($q) use ($my_business) {
                    $q->where('status', 'Active');
                })
                ->whereNull('deleted_at')
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'amenities', 'website', 'people_search', 'description', 'images', 'status')
                ->with(['user' => function ($q) {
                    $q->select('id', 'name', 'email', 'image');
                }])
                ->with(['service' => function ($q) {
                    $q->select('id', 'title', 'company_name');
                }])
                ->when($my_business, function ($q) use ($my_business) {
                    $q->where('user_id', $my_business);
                })
                ->when(!$my_business, function ($q) use ($my_business) {
                    $q->where('status', 'Active');
                })
                ->whereNull('deleted_at')
                ->orderByDesc('id')
                ->paginate(10);
        }
        if ($business) {
            return $this->sendResponse($business, 'Business Record Get Successfully.');
        }
        return $this->sendError('Record Not Found.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessRequest $request)
    {
        $validated = $request->validated();
        $services = explode(',', $request->input('service_id'));
        $validator = Validator::make(['service_id' => $services], [
            'service_id.*' => 'exists:services,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        unset($validated['service_id']);
        $validated['user_id'] = auth()->id();
        return $validated;
        $business = Business::create($validated);
        $business->service()->sync($services);
        return $this->sendResponse($business->id, 'Business Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'amenities', 'website', 'people_search', 'description', 'images', 'status')
            ->with(['user' => function ($q) {
                $q->select('id', 'name', 'email', 'image');
            }])
            ->with(['service' => function ($q) {
                $q->select('id', 'title', 'company_name');
            }])
            ->where('status', 'Active')
            ->whereNull('deleted_at')
            ->find(base64_decode($id));

        if ($business) {
            return $this->sendResponse($business, 'Business Record Get Successfully.');
        }
        return $this->sendError('Record Not Found.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessRequest $request, $id)
    {
        $business = Business::whereNull('deleted_at')->find(base64_decode($id));
        if (!$business) {
            return $this->sendError('Record Not Found.');
        }
        $validated = $request->validated();
        if ($services_id = $request->service_id) {
            $services = explode(',', $services_id);
            $validator = Validator::make(['service_id' => $services], [
                'service_id.*' => 'exists:services,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $business->service()->sync($services);
        }
        unset($validated['status']);
        $business->fill($validated)->save();
        return $this->sendResponse([], 'Business Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $business = Business::whereNull('deleted_at')->find(base64_decode($id));
        if ($business) {
            $business->fill(['deleted_at' => now()])->save();
            return $this->sendResponse([], 'Business Deleted Successfully.');
        }
        return $this->sendError('Record Not Found.');
    }

    public function ratingReview(BusinessRatingReviewRequest $request)
    {
        $validated = $request->validated();
        $user_id = Auth::user()->id;
        $rating = isset($request->rating) ? $request->rating : null;
        $review = isset($request->review) ? $request->review : null;

        if ($rating) {
            BusinessRatingReview::updateOrCreate(
                [
                    'business_id' => $request->business_id,
                    'user_id' => $user_id,
                ],
                [
                    'rating' => $request->rating,
                ]);
        }

        if ($review) {
            BusinessRatingReview::updateOrCreate(
                [
                    'business_id' => $request->business_id,
                    'user_id' => $user_id,
                ],
                [
                    'review' => $request->review,
                ]);
        }

        return $this->sendResponse([], 'Business Rating-Review Created Successfully.');
    }

    public function ratingReviewList($id)
    {
        $ratingReviewList = BusinessRatingReview::select('user_id', 'rating', 'review')->where('business_id', base64_decode($id))->get();
        return $this->sendResponse($ratingReviewList, 'Business Rating-Review Record Get SuccessFully.');
    }
}
