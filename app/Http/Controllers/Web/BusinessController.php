<?php

namespace App\Http\Controllers\Web;

use App\Common\AzureComponent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessWebRequest;
use App\Models\Business;
use App\Models\Services;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Business.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Services::whereNull('deleted_at')->where('status', 'Active')->orderByDesc('id')->get();
        return view('Admin.Business.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BusinessWebRequest $request)
    {
        $validated = $request->validated();
        $image_url = [];
        foreach ($request->images as $image) {
            $azure = new AzureComponent();
            $mediaName = $azure->store($image);
            $image_url[] = config('app.azure') . "/uploads/readwave/$mediaName";
        }
        $validated['images'] = implode(',', $image_url);
        $servicesIds = $validated['service_id'];
        unset($validated['service_id']);
        $validated['user_id'] = auth()->id();
        $business = Business::create($validated);
        $business->service()->attach($servicesIds);
        return redirect()->route('business.index')->with('success', 'Business Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business = Business::with('service')->whereNull('deleted_at')->find(base64_decode($id)) ?? abort(404);
        $images = explode(',', $business->images);
        $services = Services::whereNull('deleted_at')->where('status', 'Active')->orderByDesc('id')->get();
        return view('Admin.Business.show', compact('services', 'business', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $business = Business::with('service')->whereNull('deleted_at')->find(base64_decode($id)) ?? abort(404);
        $images = explode(',', $business->images);
        $services = Services::whereNull('deleted_at')->where('status', 'Active')->orderByDesc('id')->get();
        return view('Admin.Business.edit', compact('services', 'business', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessWebRequest $request, $id)
    {
        $business = Business::with('service')->whereNull('deleted_at')->find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        unset($validated['service_id']);
        if (isset($request->images) ? $request->images : null) {
            $image_url = [];
            $azure = new AzureComponent();
            $urlString = config('app.azure') . "/uploads/readwave/";
            if ($business->images) {
                $images = explode(',', $business->images);
                foreach ($images as $image) {
                    $oldFileName = str_replace($urlString, '', $image);
                    $azure->delete($oldFileName);
                }
            }
            foreach ($request->images as $image) {
                $mediaName = $azure->store($image);
                $image_url[] = config('app.azure') . "/uploads/readwave/$mediaName";
            }
            $validated['images'] = implode(',', $image_url);
        }
        $business->fill($validated)->save();
        $business->service()->sync($request->service_id);
        return redirect()->route('business.index')->with('success', 'Business Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $business = Business::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($business) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getData()
    {
        $data = Business::whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('business.edit', base64_encode($data->id)) . '"  title="Edit"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('business.show', base64_encode($data->id)) . '"  title="View"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('business.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->editColumn('image', function ($data) {
                $images = explode(',', $data->images);
                $html = '';
                foreach ($images as $key => $image) {
                    if ($key > 1) {
                        break;
                    }
                    if ($image) {
                        $html .= '<img src="' . $image . '" alt="Business" width="60" height="60" class="img-thumbnail">';
                    }
                }
                return $html;
            })
            ->editColumn('status', function ($data) {
                $checked = ($data->status == 'Active') ? 'checked' : '';
                return '<input type="checkbox" id="switcherySize2"  data-value="' . base64_encode($data->id) . '"  class="switchery switch" data-size="sm" ' . $checked . '  />';
            })
            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->rawColumns(['date', 'action', 'image', 'status'])
            ->addIndexColumn()
            ->toJson();
    }

    public function status($id, $status)
    {
        $service = Business::where('id', base64_decode($id))->update(['status' => $status]);
        if ($service) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function businessView($id)
    {
        $business = Business::with('service')->whereNull('deleted_at')->find(base64_decode($id)) ?? abort(404);
        $images = explode(',', $business->images);
        return view('business', compact('business', 'images'));
    }

}
