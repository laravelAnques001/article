<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DigitalServiceApplyRequest;
use App\Models\Business;
use App\Models\ServiceApply;
use App\Models\Services;
use App\Models\Setting;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = isset($request->search) ? $request->search : null;
        if ($search) {
            $services = Services::select('id', 'title', 'company_name', 'location', 'image', 'description', 'status')
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('company_name', 'like', '%' . $search . '%')
                ->orWhere('location', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $services = Services::select('id', 'title', 'company_name', 'location', 'image', 'description', 'status')
                ->whereNull('deleted_at')
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->paginate(10);
        }
        return $this->sendResponse($services, 'Services List Get Successfully.');
    }

    public function show($id)
    {
        $services = Services::select('id', 'title', 'company_name', 'location', 'image', 'description', 'status')
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

        $setting['popular_services'] = Services::select('id', 'title', 'company_name', 'location', 'image', 'description', 'status')->withCount('business')->orderByDesc('business_count')->take(8)->get();

        $setting['our_services'] = Services::select('id', 'title', 'company_name', 'location', 'image', 'description', 'status')->with('business:user_id')->whereHas('business', function ($q) {
            $q->where('user_id', auth()->id());
        })->where('status', 'Active')->get();

        return $this->sendResponse($setting, 'Discover-List Record Get SuccessFully.');
    }

    public function serviceBusinessList($id)
    {
        $serviceBusiness = Business::with('service:title')->whereHas('service', function ($q) use ($id) {
            $q->where('id', base64_decode($id));
        })->where('status', 'Active')->get();

        return $this->sendResponse($serviceBusiness, 'Service Business Record Get SuccessFully.');
    }

    public function digitalServiceApply(DigitalServiceApplyRequest $request)
    {
        $validated = $request->validated();
        ServiceApply::create($validated);
        return $this->sendResponse([], 'Service Apply Send SuccessFully.');
    }
}
