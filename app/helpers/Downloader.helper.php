<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class DownloaderHelper
{
    public static function downloadFileToStorage(String $from, $fileName) :void
    {
        $fileName .=".jpg";
        $response = file_get_contents($from);
       
        Storage::disk('profile_images')->put($fileName, $response);
    }
}
