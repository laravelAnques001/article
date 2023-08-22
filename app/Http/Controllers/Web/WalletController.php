<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin.Wallet.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id', 'name')->whereNull('deleted_at')->get();
        return view('Admin.Wallet.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletRequest $request)
    {
        $validated = $request->validated();
        Wallet::create($validated);
        $user = User::find($validated['user_id']);
        $user->increment('balance', $validated['amount']);
        return redirect()->route('wallet.index')->with('success', 'Wallet Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet = Wallet::with('user')->find(base64_decode($id)) ?? abort(404);
        return view('Admin.Wallet.show', compact('wallet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::select('id', 'name')->whereNull('deleted_at')->get();
        $wallet = Wallet::find(base64_decode($id)) ?? abort(404);
        return view('Admin.Wallet.edit', compact('wallet', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WalletRequest $request, $id)
    {
        $wallet = Wallet::find(base64_decode($id)) ?? abort(404);
        $validated = $request->validated();
        $wallet->fill($validated)->save();
        return redirect()->route('wallet.index')->with('success', 'Wallet Updated SuccessFully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wallet = Wallet::where('id', base64_decode($id))->update(['deleted_at' => now()]);
        if ($wallet) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    public function getWalletData()
    {
        $data = Wallet::with('user')->whereNull('deleted_at')->orderBy('id', 'desc');

        return DataTables::of($data)
            ->addColumn('action', function ($data) {
                $data = '<a class="font-size-16" href="' . route('wallet.edit', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-edit fa-1x"></i></a>
                <a class="font-size-16 " href="' . route('wallet.show', base64_encode($data->id)) . '"  title="Push Notification"><i class="fa fa-eye fa-1x"></i></a>
                <a class="delete_row font-size-16" data-value = "' . route('wallet.destroy', base64_encode($data->id)) . '" title = "Delete"><i class="fa fa-trash-o"></i></a>';
                return $data;
            })
            ->editColumn('user_id', function ($data) {
                return $data->user->name;
            })
            ->rawColumns(['action', 'user_id'])
            ->addIndexColumn()
            ->toJson();
    }
}
