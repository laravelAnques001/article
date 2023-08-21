<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'email' => 'nullable|string|email',
            'mobile_number' => 'nullable|digits_between:10,12',
            'dial_code' => 'nullable|digits_between:1,4',
            'type' => 'required|in:email,mobile_number',
        ]);

        if ($request->type == 'mobile_number') {
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|string|email|unique:users,email',
            ]);
        }

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $dial_code = isset($request->dial_code) ? $request->dial_code : 91;
        $mobile_number = isset($request->mobile_number) ? $request->mobile_number : null;
        $email = isset($request->email) ? $request->email : null;
        unset($input['type']);

        if ($request->type == 'email') {
            $user = User::where('email', $email)->first();
            unset($input['email']);
            if ($user) {
                $user->fill($input)->save();
            } else {
                return $this->sendError('Validation Error.', ["email" => 'Email Not Valid']);
            }
        } elseif ($request->type == 'mobile_number') {
            $user = User::where('dial_code', $dial_code)->where('mobile_number', $mobile_number)->first();
            unset($input['mobile_number']);
            unset($input['dial_code']);
            if ($user) {
                $user->fill($input)->save();
            } else {
                return $this->sendError('Validation Error.', ["mobile_number" => 'Mobile Number Not Valid']);
            }
        }
        return $this->sendResponse([], 'User register successfully.');
    }

    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'nullable|email',
            'dial_code' => 'nullable|digits_between:1,4',
            'mobile_number' => 'nullable|digits_between:10,12',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Errors!');
        }

        $dial_code = isset($request->dial_code) ? $request->dial_code : 91;
        $mobile_number = isset($request->mobile_number) ? $request->mobile_number : null;
        $email = isset($request->email) ? $request->email : null;
        // $userOtp = rand(1000, 9999);
        $userOtp = 1234;
        $expire_at = now()->addMinute(10);

        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->fill([
                    'otp' => $userOtp,
                    'expire_at' => $expire_at,
                ])->save();
            } else {
                $user = User::create([
                    'email' => $email,
                    'otp' => $userOtp,
                    'expire_at' => $expire_at,
                ]);
            }
            // $user->notify(new SendOTPEmail($userOtp));
            return $this->sendResponse([], 'Your Email OTP Send SuccessFully');
        }

        if ($mobile_number && $dial_code) {
            $user = User::where('dial_code', $dial_code)->where('mobile_number', $mobile_number)->first();
            if ($user) {
                $user->fill([
                    'otp' => $userOtp,
                    'expire_at' => $expire_at,
                ])->save();
            } else {
                $user = User::create([
                    'dial_code' => $dial_code,
                    'mobile_number' => $mobile_number,
                    'otp' => $userOtp,
                    'expire_at' => $expire_at,
                ]);
            }
            return $this->sendResponse($userOtp, 'Your Mobile Number OTP Send SuccessFully');
        }
    }

    // public function otpGenerate(Request $request)
    // {
    //     $validated = Validator::make($request->all(), [
    //         'mobile_number' => 'nullable|exists:users,mobile_number',
    //         'dial_code' => 'nullable|digits_between:1,4',
    //         'email' => 'nullable|email',
    //     ]);

    //     if ($validated->fails()) {
    //         return $this->sendError($validated->errors(), 'Validation Errors!');
    //     }

    //     $dial_code = isset($request->dial_code) ? $request->dial_code : 91;
    //     $user = User::where('dial_code', $dial_code)->where('mobile_number', $request->mobile_number)->first();
    //     $userOtp = rand(1000, 9999);
    //     $expire_at = now()->addMinute(10);
    //     $user->fill([
    //         'otp' => $userOtp,
    //         'expire_at' => $expire_at,
    //     ])->save();

    //     return $this->sendResponse([], 'User SMS Send Successfully.');
    // }

    public function otpVerify(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'dial_code' => 'nullable|digits_between:1,4',
            'mobile_number' => 'nullable|exists:users,mobile_number|digits_between:10,12',
            'email' => 'nullable|exists:users,email',
            'otp' => 'required|numeric|digits:4',
            'device_token' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            return $this->sendError($validated->errors(), 'Validation Errors!');
        }
        $dial_code = isset($request->dial_code) ? $request->dial_code : 91;
        $mobile_number = isset($request->mobile_number) ? $request->mobile_number : null;
        $email = isset($request->email) ? $request->email : null;
        $device_token = isset($request->device_token) ? $request->device_token : null;

        if ($email) {
            $user = User::where('email', $email)->where('otp', $request->otp)->where('expire_at', '>=', now())->first();
            if (!$user) {
                return $this->sendError(["otp" => ['OTP Not Valid!']], '');
            }
        }
        if ($mobile_number && $dial_code) {
            $user = User::where('dial_code', $dial_code)->where('mobile_number', $mobile_number)->where('otp', $request->otp)->first();
            if (!$user) {
                return $this->sendError(["otp" => ['OTP Not Valid!']], '');
            }
        }
        if ($user) {
            $user->fill([
                'otp' => null,
                'expire_at' => null,
                'device_token' => $device_token,
            ])->save();

            Auth::login($user);
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['mobile_number'] = $user->mobile_number;
            $success['dial_code'] = $user->dial_code;
            $success['image_url'] = $user->image_url;
            $success['token'] = $user->createToken('FriendsPointArticle')->accessToken;
            $success['category'] = $user->category->pluck('id')->toArray();
            return $this->sendResponse($success, 'User Login Successfully.');
        }
        return $this->sendError([], 'Email Or Mobile Number Field Required');
    }

    public function logout(Request $request)
    {
        $result = $request->user()->token()->revoke();
        if ($result) {
            return $this->sendResponse([], 'User Logout Successfully.', 200);
        } else {
            return $this->sendError([], 'Something Is Wrong.', 400);
        }
    }

    // public function forgetPassword(Request $request)
    // {
    //     $validated = Validator::make($request->all(), [
    //         'email' => 'required|exists:users,email',
    //     ]);

    //     if ($validated->fails()) {
    //         return $this->sendError($validated->errors(), 'Validation Error.');
    //     }
    //     $token = Str::random(60);
    //     DB::table('password_resets')->insert([
    //         'email' => $request->email,
    //         'token' => $token,
    //     ]);
    //     $user = User::where('email', $request->email)->first();
    //     $user->notify(new ForgetPassword($token));
    //     return $this->sendResponse([], 'Send Token Your Email Successfully.', 200);
    // }

    public function profileUpdate(Request $request)
    {
        $userId = auth()->id();
        $validated = Validator::make($request->all(), [
            'name' => 'nullable|string|min:3',
            'email' => 'nullable|email|unique:users,email,' . $userId,
            'mobile_number' => 'nullable|digits_between:10,12|unique:users,mobile_number,' . $userId,
            'image' => 'nullable|image',
            'category_id' => 'nullable',
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
        if ($categoryIds = $request->category_id) {
            $categories = explode(',', $categoryIds);
            $user->category()->sync($categories);
        }

        $user->fill($validated)->save();
        return $this->sendResponse(new UserResource($user), 'Profile Updated SuccessFully.');
    }

    // public function getFirebaseToken($user)
    // {
    //     $passData = [
    //         'email' => $user->email,
    //         'password' => $user->password,
    //         'returnSecureToken' => true,
    //     ];
    //     $apiKey = env('FIREBASE_API_KEY');
    //     $url = config('app.firebase_api') . ':signInWithPassword?key=' . $apiKey;
    //     $response = $this->curl_data($url, $passData);
    //     return json_decode($response);
    // }

    public function setting($key)
    {
        $setting = Setting::where('key', $key)->first();
        if ($setting) {
            return $this->sendResponse($setting->value, 'Setting Data get SuccessFully.');
        } else {
            return $this->sendError('Key not valid');
        }
    }
}
