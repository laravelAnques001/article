<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertiseRequest;
use App\Models\Advertise;
use App\Models\Article;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Advertise.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = Article::whereNull('deleted_at')->get();
        return view('Admin.Advertise.create', compact('articles'));
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
        Advertise::create($validated);
        return redirect()->route('advertise.index')->with('success', 'Advertise Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Advertise::with('article')->find(base64_decode($id));
        $advertise = isset($data) ? $data : abort(404);
        return view('Admin.Advertise.show', compact('advertise'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articles = Article::whereNull('deleted_at')->get();
        $advertise = Advertise::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Advertise.edit', compact('advertise', 'articles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertiseRequest $request, $id)
    {
        $advertise = Advertise::find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        $advertise->fill($validated)->save();
        return redirect()->route('advertise.index')->with('success', 'Advertise Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertise = Advertise::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($advertise) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getAdvertiseData()
    {
        $data = Advertise::with('article')->whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            // ->addColumn('status', function ($data) {
            //     $checked = ($data->status == 'Publish') ? 'checked' : '';
            //     return '<input type="checkbox" id="switcherySize2"  data-value="' . base64_encode($data->id) . '"  class="switchery switch" data-size="sm" ' . $checked . '  />';
            // })
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('advertise.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('advertise.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('advertise.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->editColumn('target', function ($data) {
                if ($data->target == 0) {
                    return '<span>All</span>';
                } elseif ($data->target == 1) {
                    return '<span>Own</span>';
                }
                return;
            })
            ->editColumn('article_id', function ($data) {
                return isset($data->article->title) ? $data->article->title : '';
            })
            ->rawColumns(['action', 'target', 'status', 'article_id'])
            ->addIndexColumn()
            ->toJson();
    }

    public function status($id, $status)
    {
        $advertise = Advertise::where('id', base64_decode($id))->update(['status' => $status]);
        if ($advertise) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
}
