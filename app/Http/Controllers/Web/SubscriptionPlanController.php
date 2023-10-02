<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPlanWebRequest;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.SubscriptionPlan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.SubscriptionPlan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionPlanWebRequest $request)
    {
        $validated = $request->validated();
        SubscriptionPlan::create($validated);
        return redirect()->route('subscriptionPlan.index')->with('success', 'Subscription Plan Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscriptionPlan = SubscriptionPlan::find(base64_decode($id)) ?? abort(404);
        return view('Admin.SubscriptionPlan.show', compact('subscriptionPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscriptionPlan = SubscriptionPlan::find(base64_decode($id)) ?? abort(404);
        return view('Admin.SubscriptionPlan.edit', compact('subscriptionPlan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriptionPlanWebRequest $request, $id)
    {
        $service = SubscriptionPlan::find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        $service->fill($validated)->save();
        return redirect()->route('subscriptionPlan.index')->with('success', 'Subscription Plan Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscriptionPlan = SubscriptionPlan::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($subscriptionPlan) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getData()
    {
        $data = SubscriptionPlan::whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('subscriptionPlan.edit', base64_encode($data->id)) . '"  title="Edit"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('subscriptionPlan.show', base64_encode($data->id)) . '"  title="View"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('subscriptionPlan.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->editColumn('image', function ($data) {
                if ($data->image_url) {
                    return '<img src="' . $data->image_url . '" alt="Subscription Plan" width="60" height="60" class="img-thumbnail">';
                } else {
                    return;
                }
            })
            ->editColumn('status', function ($data) {
                $checked = ($data->status == 'Active') ? 'checked' : '';
                return '<input type="checkbox" id="switcherySize2"  data-value="' . base64_encode($data->id) . '"  class="switchery switch" data-size="sm" ' . $checked . '  />';
            })
            ->rawColumns(['date', 'action', 'image', 'status'])
            ->addIndexColumn()
            ->toJson();
    }

    public function status($id, $status)
    {
        $subscriptionPlan = SubscriptionPlan::where('id', base64_decode($id))->update(['status' => $status]);
        if ($subscriptionPlan) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}
