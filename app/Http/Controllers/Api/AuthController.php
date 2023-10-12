<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Business;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\SendOTPEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Common\GeneralComponent;
class AuthController extends Controller
{
    public $general;

    public function __construct() {
        $this->general = new GeneralComponent();
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'type' => 'required|in:email,mobile_number',
            'email' => ['required_if:type,email', 'string', 'email', 'unique:users,email'],
            'mobile_number' => ['required_if:type,mobile_number', 'digits_between:10,12'],
            'dial_code' => 'nullable|digits_between:1,4',
            'user_type' => 'required|in:Regular,Business',
            'business_name' => ['required_if:user_type,Business', 'string','unique:businesses,business_name'],
        ]);

        // if ($request->type == 'mobile_number') {
        //     $validator = Validator::make($request->all(), [
        //         'email' => 'nullable|string|email|unique:users,email',
        //     ]);
        // }

        if ($validator->fails()) {
            return response()->json(['success' => false,'message' => $validated->errors()->first()]);
        }

        $input = $request->all();
        $dial_code = isset($request->dial_code) ? $request->dial_code : 91;
        $mobile_number = isset($request->mobile_number) ? $request->mobile_number : null;
        $email = isset($request->email) ? $request->email : null;
        $business_name = isset($request->business_name) ? $request->business_name : null;
        unset($input['type']);
        unset($input['business_name']);

        if ($request->type == 'email') {
            $user = User::where('email', $email)->first();
            unset($input['email']);
            if (!$user) {
                return $this->sendError('Email Not Valid');
            }
        } elseif ($request->type == 'mobile_number') {
            $user = User::where('dial_code', $dial_code)->where('mobile_number', $mobile_number)->first();
            unset($input['mobile_number']);
            unset($input['dial_code']);
            if (!$user) {
                return $this->sendError('Mobile Number Not Valid');
            }
        }
        $user->fill($input)->save();
        $business = Business::create([
            'business_name' => $business_name,
            'user_id' => $user->id,
        ]);
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
            return response()->json(['success' => false,'message' => $validated->errors()->first()]);
        }

        $dial_code = isset($request->dial_code) ? $request->dial_code : 91;
        $mobile_number = isset($request->mobile_number) ? $request->mobile_number : null;
        $email = isset($request->email) ? $request->email : null;

        // user OTP Genrate And Send start
        if(env('APP_ENV') == 'local'){
            $userOtp = 1234;
            $response = 200;
        }else{
            $userOtp = rand(1000, 9999);
            if ($mobile_number && $dial_code) {
                // sms send start
                $msgResponse =  $this->general->sendSMSOtp($otp, $request->mobile_number);
                return $this->sendResponse(json_decode($msgResponse)->code,$otp );
                // sms send end
            }else{
                $response = 200;
            }
        }
        $expire_at = now()->addMinute(10);
        // user OTP Genrate And Send end

        if($response == 200){
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
                $user->notify(new SendOTPEmail($userOtp));
                return $this->sendResponse(null, 'Your Email OTP Send SuccessFully');
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
                return $this->sendResponse(null, 'Your Mobile Number OTP Send SuccessFully');
            }
        }
        return $this->sendError('Server Issue OTP Not Send');
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
            return response()->json(['success' => false,'message' => $validated->errors()->first()]);
        }
        $dial_code = isset($request->dial_code) ? $request->dial_code : 91;
        $mobile_number = isset($request->mobile_number) ? $request->mobile_number : null;
        $email = isset($request->email) ? $request->email : null;
        $device_token = isset($request->device_token) ? $request->device_token : null;
        $user = null;
        if ($email) {
            $user = User::where('email', $email)->where('otp', $request->otp)->whereNotNull('expire_at')->where('expire_at', '>=', now())->first();
            if (!$user) {
                return $this->sendError('OTP not valid!');
            }
        }
        if ($mobile_number && $dial_code) {
            $user = User::where('dial_code', $dial_code)->where('mobile_number', $mobile_number)->whereNotNull('expire_at')->where('expire_at', '>=', now())->where('otp', $request->otp)->first();
            if (!$user) {
                return $this->sendError('OTP not valid!');
            }
        }
        if ($user) {
            $user->fill([
                'otp' => null,
                'expire_at' => null,
                'device_token' => $device_token,
            ])->save();

            $business = Business::where('user_id', $user->id)->whereNull('gst_number')->latest()->first();
            $business_profile = isset($business) ? false : true;
            $business_id = isset($business->id) ? $business->id : 0;
            $business_name = isset($business->business_name) ? $business->business_name : null;

            Auth::login($user);
            $success['id'] = $user->id;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['mobile_number'] = $user->mobile_number;
            $success['dial_code'] = $user->dial_code;
            $success['image_url'] = $user->image_url;
            $success['token'] = $user->createToken('FriendsPointArticle')->accessToken;
            $success['category'] = $user->category->pluck('id')->toArray();
            $success['business_id'] = $business_id;
            $success['business_name'] = $business_name;
            $success['business_profile'] = $business_profile;
            return $this->sendResponse($success, 'User Login Successfully.');
        }
        return $this->sendError('Email Or Mobile Number Field Required');
    }

    public function logout(Request $request)
    {
        $result = $request->user()->token()->revoke();
        if ($result) {
            return $this->sendResponse([], 'User Logout Successfully.', 200);
        } else {
            return $this->sendError('Something Is Wrong.');
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
            // 'image' => 'nullable|image',
            'image' => 'nullable|string',
            'category_id' => 'nullable',
        ]);

        if ($validated->fails()) {
            return response()->json(['success' => false,'message' => $validated->errors()->first()]);
        }
        $validated = $request->all();
        $user = User::with('business')->find($userId);
   
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
        }
        return $this->sendError('Key not valid');

    }
}
