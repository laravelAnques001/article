<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletTransactionRequest;
use App\Http\Resources\WalletResource;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmail;
use App\Models\AdminNotification;

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
        $minBalance = Setting::where('key','min_balance')->first();
        $success = [
            'wallet' => $wallet,
            'balance' => $user->balance,
            'min_balance' => ((int) $minBalance->value),
        ];
        return $this->sendResponse($success, 'Wallet Record Get SuccessFully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(WalletTransactionRequest $request)
    public function store(Request $request)
    {
        $userId = auth()->id();
        $validated = $request->all();
        $validator = Validator::make($validated, [
            'transaction_id' => 'required|string',
            'payment_response' => 'required|string',
            'status' => 'required|in:CANCEL,FAILURE,SUCCESS',
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        if ($request->status == 'SUCCESS') {
            $user = User::where('id', $userId)->first();
            $user->balance += $request->amount;
            $user->save();
        }
        $validated['user_id'] = $userId;
        $wallet = Wallet::create($validated);
        $validated['user_name'] = isset($wallet->user->name) ? $wallet->user->name : null;

        // if($email =isset($wallet->user->name) ? $wallet->user->name : null){
        //     SendEmail::dispatchSync( [
        //         'subject' => 'Wallet Balance Added : ',
        //         'data' => $validated,
        //         'email' => $email,
        //         'view' => 'Wallet',
        //     ]);
        // }
        js_send_email('Wallet Balance Added: '.$validated['user_name'],  $validated,  config('mail.from.address'),'Wallet');
        // SendEmail::dispatchSync( [
        //     'subject' => 'Wallet Balance Added: '.$validated['user_name'],
        //     'data' => $validated,
        //     'email' => config('mail.from.address'),
        //     'view' => 'Wallet',
        // ]);

        AdminNotification::create([
            'title'=>'Wallet Transaction ID:'. $validated['transaction_id'],
            'description'=>$validated['payment_response'],
        ]);

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
    public function update(Request $request, $id)
    {
        $wallet = Wallet::whereNull('deleted_at')->find(base64_decode($id));
        if (!$wallet) {
            return $this->sendError('Record Not Found.');
        }

        $validated = $request->all();
        $validator = Validator::make($validated, [
            'transaction_id' => 'required|string',
            'payment_response' => 'required|string',
            'status' => 'required|in:CANCEL,FAILURE,SUCCESS',
            'amount' => 'required|regex:/^\d*(\.\d{2})?$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

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
