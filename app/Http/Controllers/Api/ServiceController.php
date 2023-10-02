<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
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
        return $this->sendError([], 'Record Not Found.');
    }
}
