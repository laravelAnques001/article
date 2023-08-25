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
}
