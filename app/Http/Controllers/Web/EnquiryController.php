<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Yajra\DataTables\Facades\DataTables;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Enquiry.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Enquiry = Enquiry::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($Enquiry) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getData()
    {
        $data = Enquiry::with('business', 'user')->whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="delete_row font-size-16" data-value = "' . route('enquiry.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->addColumn('date', function ($data) {
                return date('Y-m-d H:i:s', strtotime($data->created_at));
            })
            ->addColumn('business_name', function ($data) {
                return isset($data->business->business_name) ? $data->business->business_name : null;
            })
            ->rawColumns(['date', 'action', 'business_name'])
            ->addIndexColumn()
            ->toJson();
    }
}
