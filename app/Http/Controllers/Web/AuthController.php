<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function otpGenerate(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'mobile_number' => 'required|exists:users,mobile_number',
        ]);
        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Errors!');
        }
        $user = User::where('mobile_number', $request->mobile_number)->first();
        $userOtp = rand(1000, 9999);
        $expire_at = now()->addMinute(10);
        $user->fill([
            'otp' => $userOtp,
            'expire_at' => $expire_at,
        ])->save();

        return $this->sendResponse([], 'User SMS Send Successfully.');
    }

    public function otpVerify(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'mobile_number' => 'required|exists:users,mobile_number',
            'otp' => 'required|numeric|digits:4',
            'device_token' => 'required|string',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Errors!');
        }

        $user = User::where('mobile_number', $request->mobile_number)->where('otp', $request->otp)->where('expire_at', '>=', now())->first();
        if (!$user) {
            return $this->sendError(["otp" => ['OTP Not Valid!']], '');
        }

        $user->fill([
            'otp' => null,
            'expire_at' => null,
            'device_token' => $request->device_token,
        ])->save();

        Auth::login($user);
        $success['token'] = $user->createToken('AppExample')->accessToken;
        $success['user_detail'] = new UserResource($user);

        return $this->sendResponse($success, 'User Login Successfully.');
    }

    public function forgetPassword(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Error.');
        }
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
        ]);
        $user = User::where('email', $request->email)->first();
        $user->notify(new ForgetPassword($token));
        return $this->sendResponse([], 'Send Token Your Email Successfully.', 200);
    }

    public function profile()
    {
        $user = Auth::user();
        $users = User::where('id', "=", $user->id)->first();
        return view('Admin/Auth/profile', ['users' => $users]);
    }

    public function profileUpdate(Request $request)
    {
        $userId = auth()->id();
        $validated = Validator::make($request->all(), [
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email|unique:users,email,' . $userId,
            'mobile_number' => 'nullable|digits_between:10,12|unique:users,mobile_number,' . $userId,
            'image' => 'nullable|image',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Error.');
        }
        $validated = $request->all();
        $user = User::find($userId);

        if ($image = $request->image ?? null) {
            if ($oldImage = $user->image ?? null) {
                $fileCheck = storage_path('app/' . $oldImage);
                if (file_exists($fileCheck)) {
                    unlink($fileCheck);
                }
            }
            $validated['image'] = $image->store('public/user');
        }

        $user->fill($validated)->save();
        return redirect()->route('dashboard')->with('success', 'Profile Updated SuccessFully.');
    }

    public function resetPassword()
    {
        $user = Auth::user();
        $users = User::where('id', "=", $user->id)->first();
        return view('Admin/Auth/resetPassword', ['users' => $users]);
    }

    public function resetPasswordStore(Request $request)
    {
        $validate = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user = User::where('id', $user->id)->first();
            $user->password = Hash::make($request->new_password);
            $user->save();
            if ($user) {
                return Redirect::back()->with('success', 'Your Password has been changed!.');
            } else {
                return Redirect::back()->with('error', 'Something wrong please try again.');
            }
        } else {
            return Redirect::back()->with('error', 'Current Password in incorrect.');
        }
    }

}
