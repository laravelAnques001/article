<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\ServiceApply;
use App\Models\Services;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmail;
use App\Models\AdminNotification;


class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = isset($request->search) ? $request->search : null;
        $typeAll = isset($request->type) ? $request->type : null;
        
        if ($search) {
            $services = Services::select('id', 'title', 'company_name', 'location', 'image', 'description', 'short_description', 'status')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('company_name', 'like', '%' . $search . '%')
                ->orWhere('location', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->paginate(10);
        } elseif($typeAll =='all') {            
            $services = Services::select('id', 'title')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->get();
        } else {
            $services = Services::select('id', 'title', 'company_name', 'location', 'image', 'short_description', 'description', 'status')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->paginate(10);
        }
        return $this->sendResponse($services, 'Services List Get Successfully.');
    }

    public function show($id)
    {
        $services = Services::select('id', 'title', 'company_name', 'location', 'image', 'short_description', 'description', 'status')
            ->whereNull('deleted_at')
            ->where('status', 'Active')
            ->find(base64_decode($id));
        if ($services) {
            return $this->sendResponse($services, 'Services Record Show SuccessFully.');
        }
        return $this->sendError('Record Not Found.');
    }

    public function discoverList()
    {
        $setting = Setting::whereIn('key', ['first_discover_banner', 'second_discover_banner'])->pluck('value', 'key')->toArray();

        $setting['popular_services'] = Services::select('id', 'title', 'company_name', 'location', 'image', 'short_description', 'description', 'status')->withCount('business')->orderByDesc('business_count')->take(8)->get();

        // $setting['our_services'] = Services::select('id', 'title', 'company_name', 'location', 'image', 'short_description', 'description', 'status')->with('business:user_id')->whereHas('business', function ($q) {
        //     $q->where('user_id', auth()->id());
        // })->where('status', 'Active')->get();

        $setting['our_services'] = Services::select('id', 'title', 'company_name', 'location', 'image', 'short_description', 'description', 'status')->where('status', 'Active')->orderByDesc('id')->get();

        return $this->sendResponse($setting, 'Discover-List Record Get SuccessFully.');
    }

    public function serviceBusinessList(Request $request,$id)
    {
        $search = isset($request->search) ? $request->search : null;
        if($search){
            $serviceBusiness = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time', 'website', 'people_search', 'description', 'images', 'status', 'location', 'contact_number')
            ->with(['service' => function ($q)  use($id,$search) {
                $q->select('id', 'title', 'company_name');
                $q->where('id', base64_decode($id));
                $q->orWhere('title','like','%'.$search.'%');
                $q->orWhere('company_name','like','%'.$search.'%');
            }])
            ->with(['aminity' => function ($q) use($search) {
                $q->select('id', 'name');
                $q->where('name','like','%'.$search.'%');
            }])
            ->with('ratingReview')
            ->whereNull('deleted_at')
            ->where('status', 'Approved')
            ->where('business_name', 'like', '%' . $search . '%')
            ->orWhere('gst_number', 'like', '%' . $search . '%')
            ->orWhere('year', 'like', '%' . $search . '%')
            ->orWhere('start_time', 'like', '%' . $search . '%')
            ->orWhere('end_time', 'like', '%' . $search . '%')
            ->orWhere('website', 'like', '%' . $search . '%')
            ->orWhere('location', 'like', '%' . $search . '%')
            ->orWhere('contact_number', 'like', '%' . $search . '%')
            ->orWhere('people_search', 'like', '%' . $search . '%')
            ->paginate(10);
        }else{
            $serviceBusiness = Business::select('id', 'user_id', 'business_name', 'gst_number', 'year', 'start_time', 'end_time',  'website', 'people_search', 'description', 'images', 'status', 'location', 'contact_number')
                ->with('ratingReview')
                ->with(['service' => function ($q) use ($id) {
                    $q->select('id', 'title', 'company_name');
                    $q->where('id', base64_decode($id));
                }])
                ->with(['aminity' => function ($q) {
                    $q->select('id', 'name');
                }])
                ->whereNull('deleted_at')
                ->where('status', 'Approved')
                ->paginate(10);
        }

        return $this->sendResponse($serviceBusiness, 'Service Business Record Get SuccessFully.');
    }

    public function digitalServiceApply(Request $request)
    {
        $validated = $request->all();
        $validator = Validator::make($validated, [
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string',
            'mobile_number' => 'required|digits_between:10,12',
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        
        $validated['user_id'] = auth()->id();
        ServiceApply::create($validated);

        // SendEmail::dispatchSync( [
        //     'subject' => 'Service Apply : '.$request->name,
        //     'data' => $validated,
        //     'email' => config('mail.from.address'),
        //     'view' => 'ServiceAdmin',
        // ]);
        js_send_email( 'Service Apply : '.$request->name,  $validated,  config('mail.from.address'),'ServiceAdmin');

        AdminNotification::create([
            'title'=>'Enquiry:'. $validated['name'],
            'description'=>$validated['message'],
        ]);
        return $this->sendResponse([], 'Service Apply Send SuccessFully.');
    }
}
