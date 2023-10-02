<?php

namespace App\Http\Controllers\Web;

use App\Common\AzureComponent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceWebRequest;
use App\Models\Services;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceWebRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $azure = new AzureComponent();
            $validated['image'] = $azure->store($request->image);
        }
        Services::create($validated);
        return redirect()->route('services.index')->with('success', 'Services Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $services = Services::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Services.show', compact('services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $services = Services::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Services.edit', compact('services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceWebRequest $request, $id)
    {
        $service = Services::find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        if ($image = isset($request->image) ? $request->image: null) {
            $azure = new AzureComponent();
            $oldImage = isset($service->image) ? $service->image : null;
            if ($oldImage) {
                $azure->delete($oldImage);
            }
            $validated['image'] = $azure->store($image);
        }
        $service->fill($validated)->save();
        return redirect()->route('services.index')->with('success', 'Services Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Services::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($service) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getData()
    {
        $data = Services::whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('services.edit', base64_encode($data->id)) . '"  title="Edit"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('services.show', base64_encode($data->id)) . '"  title="View"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('services.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->editColumn('image', function ($data) {
                if ($data->image_url) {
                    return '<img src="' . $data->image_url . '" alt="Services" width="60" height="60" class="img-thumbnail">';
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
        $service = Services::where('id', base64_decode($id))->update(['status' => $status]);
        if ($service) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}
