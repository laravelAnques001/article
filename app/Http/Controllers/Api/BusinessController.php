<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessRatingReviewRequest;
use App\Models\Aminity;
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
        // $my_business = isset($request->my_business) ? auth()->id() : null;
        if ($search) {
            $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'website', 'people_search', 'description', 'images', 'status', 'location', 'contact_number')
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
                ->with(['aminity' => function ($q) use ($search) {
                    $q->select('id', 'name');
                    $q->where('name', 'like', '%' . $search . '%');
                }])
                ->with('ratingReview')
                ->where('business_name', 'like', '%' . $search . '%')
                ->orWhere('gst_number', 'like', '%' . $search . '%')
                ->orWhere('year', 'like', '%' . $search . '%')
                ->orWhere('start_time', 'like', '%' . $search . '%')
                ->orWhere('end_time', 'like', '%' . $search . '%')
                ->orWhere('website', 'like', '%' . $search . '%')
                ->orWhere('location', 'like', '%' . $search . '%')
                ->orWhere('contact_number', 'like', '%' . $search . '%')
                ->orWhere('people_search', 'like', '%' . $search . '%')
            // ->when($my_business, function ($q) use ($my_business) {
            //     $q->where('user_id', $my_business);
            // })
            // ->when(!$my_business, function ($q) use ($my_business) {
            //     $q->where('status', 'Approved');
            // })
                ->whereNull('deleted_at')
                ->where('status', 'Approved')
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'website', 'people_search', 'description', 'images', 'status', 'location', 'contact_number')
                ->with(['user' => function ($q) {
                    $q->select('id', 'name', 'email', 'image');
                }])
                ->with(['aminity' => function ($q) {
                    $q->select('id', 'name');
                }])
                ->with('ratingReview')
                ->with(['service' => function ($q) {
                    $q->select('id', 'title', 'company_name');
                }])
            // ->when($my_business, function ($q) use ($my_business) {
            //     $q->where('user_id', $my_business);
            // })
            // ->when(!$my_business, function ($q) use ($my_business) {
            //     $q->where('status', 'Approved');
            // })
                ->whereNull('deleted_at')
                ->where('status', 'Approved')
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
    public function store(Request $request)
    {
        $validated = $request->all();
        $services = array_filter((explode(',', $request->input('service_id'))), 'strlen');
        $aminities = array_filter((explode(',', $request->input('aminity_id'))), 'strlen');
        $validated['service_id'] = $services;
        $validated['aminity_id'] = $aminities;
        $validator = Validator::make($validated, [
            'business_name' => 'required|string',
            'gst_number' => 'nullable',
            'service_id' => 'nullable|exists:services,id',
            'year' => ['nullable', 'date_format:Y', 'before_or_equal:' . date('Y')],
            'start_time' => 'nullable|date_format:H:i:s',
            'end_time' => 'nullable|date_format:H:i:s|after_or_equal:start_time',
            'website' => 'nullable|string|url',
            'people_search' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
            'location' => 'nullable|string',
            'contact_number' => 'nullable|digits_between:7,17',
            'service_id.*' => 'exists:services,id',
            'aminity_id.*' => 'exists:aminities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        unset($validated['service_id']);
        unset($validated['aminity_id']);
        $validated['user_id'] = auth()->id();
        $business = Business::create($validated);
        $business->service()->sync($services);
        $business->aminity()->sync($aminities);
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
        $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'website', 'people_search', 'description', 'images', 'status', 'location', 'contact_number')
            ->with(['user' => function ($q) {
                $q->select('id', 'name', 'email', 'image');
            }])
            ->with(['aminity' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with('ratingReview')
            ->with(['service' => function ($q) {
                $q->select('id', 'title', 'company_name');
            }])
            ->where('status', 'Approved')
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
    public function update(Request $request, $id)
    {
        $business = Business::whereNull('deleted_at')->find(base64_decode($id));
        if (!$business) {
            return $this->sendError('Record Not Found.');
        }
        $validated = $request->all();
        $services = array_filter((explode(',', $request->input('service_id'))), 'strlen');
        $aminities = array_filter((explode(',', $request->input('aminity_id'))), 'strlen');
        $validated['service_id'] = $services;
        $validated['aminity_id'] = $aminities;
        $validator = Validator::make($validated, [
            'business_name' => 'required|string',
            'gst_number' => 'nullable',
            'service_id' => 'nullable|exists:services,id',
            'year' => ['nullable', 'date_format:Y', 'before_or_equal:' . date('Y')],
            'start_time' => 'nullable|date_format:H:i:s',
            'end_time' => 'nullable|date_format:H:i:s|after_or_equal:start_time',
            'website' => 'nullable|string|url',
            'people_search' => 'nullable|string',
            'description' => 'nullable|string',
            'images' => 'nullable|string',
            'location' => 'nullable|string',
            'contact_number' => 'nullable|digits_between:7,17',
            'service_id.*' => 'exists:services,id',
            'aminity_id.*' => 'exists:aminities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        unset($validated['service_id']);
        unset($validated['aminity_id']);
        unset($validated['status']);
        if ($request->input('service_id')) {
            $business->service()->sync($services);
        }
        if ($request->input('aminity_id')) {
            $business->aminity()->sync($aminities);
        }
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

    // public function ratingReview(BusinessRatingReviewRequest $request)
    public function ratingReview(Request $request)
    {
        $validated = $request->all();
        $validator = Validator::make($validated, [
            'business_id' => 'required|exists:businesses,id',
                'rating' => ['nullable', 'numeric', 'between:0.01,5', 'regex:/^\d+(\.\d{2})?$/'],
                'review' => 'nullable|string',
            ]);
    
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
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
        $ratingReviewList = BusinessRatingReview::select('user_id', 'rating', 'review')->where('business_id', base64_decode($id))->paginate(10);
        return $this->sendResponse($ratingReviewList, 'Business Rating-Review Record Get SuccessFully.');
    }

    public function myBusinessList(Request $request)
    {
        $user_id = Auth::id();
        $search = isset($request->search) ? $request->search : null;

        if ($search) {
            $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'website', 'people_search', 'description', 'images', 'status', 'location', 'contact_number')
                ->with(['service' => function ($q) use ($search) {
                    $q->select('id', 'title', 'company_name');
                    $q->where('title', 'like', '%' . $search . '%');
                    $q->orWhere('company_name', 'like', '%' . $search . '%');
                }])
                ->with(['aminity' => function ($q) use($search) {
                    $q->select('id', 'name');
                    $q->where('name','like','%'.$search.'%');
                }])
                ->with(['subscriptionPlan' => function ($q) {
                    $q->select('id', 'business_id', 'payment_response','subscription_plan_id');
                }])
                ->with('ratingReview')
                ->where('user_id', $user_id)
                ->whereNull('deleted_at')
                ->where('business_name', 'like', '%' . $search . '%')
                ->orWhere('gst_number', 'like', '%' . $search . '%')
                ->orWhere('year', 'like', '%' . $search . '%')
                ->orWhere('start_time', 'like', '%' . $search . '%')
                ->orWhere('end_time', 'like', '%' . $search . '%')
                ->orWhere('website', 'like', '%' . $search . '%')
                ->orWhere('location', 'like', '%' . $search . '%')
                ->orWhere('contact_number', 'like', '%' . $search . '%')
                ->orWhere('people_search', 'like', '%' . $search . '%')
                ->orderByDesc('id')
                ->paginate(10);
              
        } else {
            $business = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'website', 'people_search', 'description', 'images', 'status', 'location', 'contact_number')
                ->with('ratingReview')
                ->with(['service' => function ($q) {
                    $q->select('id', 'title', 'company_name');
                }])
                ->with(['subscriptionPlan' => function ($q) {
                    $q->select('id', 'business_id', 'payment_response','subscription_plan_id');
                }])
                ->with(['aminity' => function ($q) {
                    $q->select('id', 'name');
                }])
                ->where('user_id', $user_id)
                ->whereNull('deleted_at')
                ->orderByDesc('id')
                ->paginate(10);
        }
        return $this->sendResponse($business, 'My Business Record Get Successfully.');

    }

    public function aminityList(Request $request)
    {
        $aminity = Aminity::select('id', 'name')->whereNull('deleted_at')->orderByDesc('id')->get();
        return $this->sendResponse($aminity, 'Aminities Record Get Successfully.');
    }
}
