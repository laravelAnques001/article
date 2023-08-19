<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\PollsRequest;
use App\Models\Polls;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PollsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Polls.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.Polls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PollsRequest $request)
    {
        $validated = $request->validated();
        if ($image = $request->image) {
            $validated['image'] = $image->store('public/polls');
        }
        Polls::create($validated);
        return redirect()->route('polls.index')->with('success', 'Polls Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $polls = Polls::whereNull('deleted_at')->find(base64_decode($id)) ?? abort(404);
        return view('Admin.polls.show', compact('polls'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $polls = Polls::whereNull('deleted_at')->find(base64_decode($id)) ?? abort(404);
        return view('Admin.polls.edit', compact('polls'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PollsRequest $request, $id)
    {

        $polls = Polls::find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        $image = isset($validated['image']) ? $validated['image'] : null;
        if ($image) {
            if ($oldImage = $polls->image ?? null) {
                $fileCheck = storage_path('app/' . $oldImage);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['image'] = $image->store('public/polls');
        }
        $polls->fill($validated)->save();
        return redirect()->route('polls.index')->with('success', 'Polls Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $polls = Polls::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($polls) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getPollsData()
    {
        $data = Polls::whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('polls.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('polls.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('polls.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->editColumn('link', function ($data) {
                return '<a href="' . $data->link . '"  title="Polls" target="_blank">' . $data->link . '</a>';
            })
            ->editColumn('image', function ($data) {
                return '<img src="' . $data->image_url . '" alt="Polls Image" width="60" height="60" class="img-thumbnail">';
            })->rawColumns(['date', 'action', 'image', 'link'])
            ->addIndexColumn()
            ->toJson();
    }

}
