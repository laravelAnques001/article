<?php

namespace App\Common;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class GeneralComponent
{
    public function curl_data($url = null, $data = array(), $header = ['Content-Type: application/json'])
    {
        if ($url) {
            $encodedData = json_encode($data);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            $result = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $result;
        }
        return;
    }

    public function sendSMSOtp($OTP = 1234, $mobileNumber, $textMessage = null)
    {
        $message = isset($textMessage) ? $textMessage : "Hi, Your account OTP is $OTP. Welcome to Bizzbrains, Online Learning Platform. For any Query Call us - 8685868788";
        if ($mobileNumber) {
            $postData = array(
                'api_id' => config('constants.SMS_API_ID'),
                'api_password' => config('constants.SMS_API_PASSWORD'),
                'sms_type' => config('constants.SMS_TYPE'),
                'sms_encoding' => config('constants.SMS_ENCODING'),
                'sender' => config('constants.SENDER'),
                'number' => $mobileNumber,
                'message' => $message,
                'response' => 'json',
            );
            $data_string = json_encode($postData);

            $ch = curl_init('http://bulksmsplans.com/api/send_sms');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );

            $response = curl_exec($ch);
            $err = curl_error($ch);
            if($err) {
                return $err;
            }
            return $response;
        } else {
            return 'Mobile Number Required.';
        }
    }
}
