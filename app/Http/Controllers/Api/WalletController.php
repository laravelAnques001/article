<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletTransactionRequest;
use App\Http\Resources\WalletResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start_date = isset($request->sd) ? $request->sd : null;
        $end_date = isset($request->ed) ? $request->ed : $start_date;
        $wallet = Wallet::select('id', 'user_id', 'transaction_id', 'amount', 'created_at')
            ->where('user_id', auth()->id())
            ->whereNull('deleted_at')
            ->when($start_date && $end_date, function ($q) use ($start_date, $end_date) {
                $q->whereBetween('created_at', [$start_date, $end_date]);
            })->orderByDesc('id')
            ->paginate(20);
        $user = User::find(auth()->id());
        $success = [
            'wallet' => $wallet,
            'balance' => $user->balance,
        ];
        return $this->sendResponse($success, 'Wallet Record Get SuccessFully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletTransactionRequest $request)
    {
        $userId = auth()->id();
        $validated = $request->validated();       
        if ($request->status == 'SUCCESS') {    
            $user = User::where('id', $userId)->first();
            $user->balance += $request->amount;
            $user->save();
        }        
        $validated['user_id'] = $userId;
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
            return $this->sendError('Record Not Found.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WalletTransactionRequest $request, $id)
    {
        $wallet = Wallet::whereNull('deleted_at')->find(base64_decode($id));
        if (!$wallet) {
            return $this->sendError('Record Not Found.');
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
            return $this->sendError('Record Not Found.');
        }
    }
}
