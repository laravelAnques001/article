<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Aminity;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AminityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Aminity.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Aminity.create');
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
            'name' => 'required|string',
        ]);
        Aminity::create(['name' => $request->name]);
        return redirect()->route('aminity.index')->with('success', 'Aminity Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aminity = Aminity::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Aminity.show', compact('aminity'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aminity = Aminity::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Aminity.edit', compact('aminity'));
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
        $Aminity = Aminity::find(base64_decode($id)) ?? abort(404);
        $input = $request->all();
        $request->validate([
            'name' => 'required|string',
        ]);
        $Aminity->fill($input)->save();
        return redirect()->route('aminity.index')->with('success', 'Aminity Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Aminity = Aminity::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($Aminity) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getData()
    {
        $data = Aminity::whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('aminity.edit', base64_encode($data->id)) . '"  title="Edit"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('aminity.show', base64_encode($data->id)) . '"  title="View"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('aminity.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->rawColumns(['date', 'action'])
            ->addIndexColumn()
            ->toJson();
    }
}
