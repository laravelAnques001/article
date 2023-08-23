<?php

namespace App\Common;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class AzureComponent
{
    public function store($file = null)
    {
        if ($file) {
            $s3 = Storage::disk('azure');
            $type_file = $file->extension();
            $strippedName = str_replace(' ', '', date('YmdHis') . $this->generateRandomString(10) . "." . $type_file);
            try {
                $s3->put('/uploads/readwave/' . $strippedName, file_get_contents($file));
            } catch (\Exception $e) {
                return json_encode(['status' => 500, 'message' => $e->getMessage()]);
            }
            return $strippedName;
        }
    }F

    public function getFile($file = null)
    {

        if ($file) {
            $s3 = Storage::disk('azure');

            $azure_storage_path = '/uploads/readwave/' . $file;

            $azure = $s3->exists($azure_storage_path);

            if ($azure) {
                $image = Config::get('app.azure') . $azure_storage_path;
            } else {
                $image = "";
            }
        } else {
            $image = "";
        }

        return $image;
    }

    public function delete($file = null)
    {
        if ($file) {
            $s3 = Storage::disk('azure');
            $s3->delete("/uploads/readwave/" . $file);
        }
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
