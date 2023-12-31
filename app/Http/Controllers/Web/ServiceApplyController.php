<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ServiceApply;
use Yajra\DataTables\Facades\DataTables;

class ServiceApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.ServiceApply.index');
    }

    public function show(string $id)
    {
        $serviceApply = ServiceApply::with('service')->whereNull('deleted_at')->find(base64_decode($id));
        return view('Admin.ServiceApply.show', compact('serviceApply'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Enquiry = ServiceApply::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($Enquiry) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getData()
    {
        $data = ServiceApply::with('service')->whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = ' <a class="font-size-16 " href="' . route('digitalServiceApply.show', base64_encode($data->id)) . '"  title="View"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('digitalServiceApply.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
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
