<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertiseRequest;
use App\Models\Advertise;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        if ($search) {
            $advertise = Advertise::select('id', 'article_id', 'target', 'latitude', 'longitude', 'redis', 'budget', 'start_date', 'end_date', 'status')
                ->with(['article' => function ($q) {
                    $q->select('id', 'title', 'media', 'created_at');
                }])
                ->orWhereHas('article', function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                })
                ->orWhere('target', 'like', '%' . $search . '%')
                ->orWhere('latitude', 'like', '%' . $search . '%')
                ->orWhere('longitude', 'like', '%' . $search . '%')
                ->orWhere('budget', 'like', '%' . $search . '%')
                ->orWhere('start_date', 'like', '%' . $search . '%')
                ->orWhere('end_date', 'like', '%' . $search . '%')
                ->whereNull('deleted_at')
                ->paginate(20);
        } else {
            $advertise = Advertise::select('id', 'article_id', 'target', 'latitude', 'longitude', 'redis', 'budget', 'start_date', 'end_date', 'status')
                ->with(['article' => function ($q) {
                    $q->select('id', 'title', 'media', 'created_at');
                }])
                ->whereNull('deleted_at')->paginate(20);
        }
        return $this->sendResponse($advertise, 'Advertise List Get Successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertiseRequest $request)
    {
        $validated = $request->validated();
        $advertise = Advertise::create($validated);
        return $this->sendResponse($advertise->id, 'Advertise Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertise = Advertise::select('id', 'article_id', 'target', 'latitude', 'longitude', 'redis', 'budget', 'start_date', 'end_date', 'status')
            ->with(['article' => function ($q) {
                $q->select('id', 'title', 'media', 'created_at');
            }])
            ->whereNull('deleted_at')
            ->find(base64_decode($id));
        if ($advertise) {
            return $this->sendResponse($advertise, 'Advertise Record Get Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }
}
