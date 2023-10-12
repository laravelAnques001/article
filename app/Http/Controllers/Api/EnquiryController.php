<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = isset($request->search) ? $request->search : null;
        if ($search) {
            $enquiry = Enquiry::with(['business' => function ($q) use ($search) {
                $q->select('id', 'business_name');
                $q->where('business_name', 'like', '%' . $search . '%');
            }])->where('id', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('mobile_number', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $enquiry = Enquiry::with(['business' => function ($q) {
                $q->select('id', 'business_name');
            }])->select('id', 'business_id', 'name', 'email', 'mobile_number')
                ->whereNull('deleted_at')
                ->where('user_id', $user->id)
                ->get();
        }
        return $this->sendResponse($enquiry, 'Enquiry Record Get SuccessFully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnquiryRequest $request)
    {
        $validated = $request->validated();
        $enquiry = Enquiry::create($validated);
        return $this->sendResponse($enquiry->id, 'Enquiry Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $enquiry = Enquiry::with(['business' => function ($q) {
            $q->select('id', 'business_name');
        }])->select('id', 'business_id', 'name', 'email', 'mobile_number')
            ->whereNull('deleted_at')
            ->where('user_id', $user->id)
            ->find(base64_decode($id));
        if ($enquiry) {
            return $this->sendResponse($enquiry, 'Enquiry Record Show SuccessFully.');
        }
        return $this->sendError('Record Not Found.');
    }
}