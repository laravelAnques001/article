<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use App\Http\Resources\WalletResource;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallet = Wallet::where('user_id', auth()->id())->whereNull('deleted_at')->orderByDesc('id')->get();
        $user = User::find(auth()->id());
        $success = [
            'transaction'=> $wallet,
            'balance'=> $user->balance,
        ];
        return $this->sendResponse($success, 'Wallet Record Get SuccessFully.');
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
        $wallet = Wallet::create($validated);
        return $this->sendResponse($wallet->id, 'Wallet Created SuccessFully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $wallet = Wallet::whereNull('deleted_at')->find(base64_decode($id));
        if ($wallet) {
            return $this->sendResponse(new WalletResource($wallet), 'Wallet Record Show SuccessFully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
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
        $wallet = Wallet::whereNull('deleted_at')->find(base64_decode($id));
        if (!$wallet) {
            return $this->sendError([], 'Record Not Found.');
        }
       
        $validated = $request->validated();
        $wallet->fill($validated)->save();
        return $this->sendResponse([], 'Wallet Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wallet = Wallet::whereNull('deleted_at')->find(base64_decode($id));
        if ($wallet) {
            $wallet->fill(['deleted_at' => now()])->save();
            return $this->sendResponse([], 'Wallet Deleted Successfully.');
        } else {
            return $this->sendError([], 'Record Not Found.');
        }
    }
}
