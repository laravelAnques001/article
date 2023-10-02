<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Common\AzureComponent;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.User.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.User.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'dial_code'=>'required|digits_between:1,4',
            'mobile_number'=>'required|digits_between:10,12',
            'device_token'=>'nullable|string',
            'image'=>'nullable|image',
        ]);

        $input = $request->all();
        if ($image = isset($request->image)?$request->image:null) {
            $azure = new AzureComponent();
            $mediaName = $azure->store($image);
            $input['image'] = config('app.azure') . "/uploads/readwave/$mediaName";
        }
        User::create($input);
        return redirect()->route('users.index')->with('success', 'User Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find(base64_decode($id)) ?? abort(404);
        return view('Admin.User.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find(base64_decode($id)) ?? abort(404);
        return view('Admin.User.edit', compact('user'));
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
        $user = User::find(base64_decode($id)) ?? abort(404);
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'dial_code'=>'required|digits_between:1,4',
            'mobile_number'=>'required|digits_between:10,12',
            'device_token'=>'nullable|string',
            'image'=>'nullable|image',
        ]);     

        $input = $request->all();
        if ($image = isset($request->image) ? $request->image : null) {
            $azure = new AzureComponent();
            $mediaName = $azure->store($image);
            $input['image'] = config('app.azure') . "/uploads/readwave/$mediaName";

            $azure = new AzureComponent();
            $urlString = config('app.azure') . "/uploads/readwave/";
            if ($oldImage = $user->image ?? null) {
                $azure->delete($oldImage);
            }
            $mediaName = $azure->store($image);
            $validated['image'] = $urlString . $mediaName;
        }
        $user->fill($input)->save();
        return redirect()->route('users.index')->with('success', 'User Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', base64_decode($id))->delete();
        if ($user) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getUserData()
    {
        $data = User::orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('users.edit', base64_encode($data->id)) . '"  title="Edit"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('users.show', base64_encode($data->id)) . '"  title="View"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('users.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->editColumn('image', function ($data) {
                if ($data->image_url) {
                    return '<img src="' . $data->image_url . '" alt="User Profile" width="60" height="60" class="img-thumbnail">';
                } else {
                    return;
                }
            })
            ->rawColumns(['action','image'])
            ->addIndexColumn()
            ->toJson();
    }
}
