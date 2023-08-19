<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Setting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validated = Validator::make($input, [
            'key' => 'required|string|min:3',
            'value' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Error.');
        }
        Setting::create($input);
        return redirect()->route('setting.index')->with('success', 'Setting Key Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = Setting::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Setting.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Setting::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Setting.edit', compact('setting'));
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
        $input = $request->all();
        $setting = Setting::find(base64_decode($id)) ?? abort(404);
        $validated = Validator::make($input, [
            'key' => 'required|string|min:3',
            'value' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Error.');
        }

        $setting->fill($input)->save();
        return redirect()->route('setting.index')->with('success', 'Setting Key Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = Setting::where('id', base64_decode($id))->delete();
        if ($setting) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getSettingData()
    {
        $data = Setting::orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('setting.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('setting.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('setting.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->editColumn('value', function ($data) {
                return $data->value ? mb_strimwidth($data->value, 0, 150, "...") : '';
            })
            ->rawColumns(['action', 'value'])
            ->addIndexColumn()
            ->toJson();
    }
}
