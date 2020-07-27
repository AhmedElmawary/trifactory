<?php
namespace App\Helpers;

class DownloaderHelper
{
    private const PATH_TO_STORAGE
            = "/var/www/html/storage/app/public/profile_images/";

    public static function downloadFileToStorage(String $from, $fileName) :void
    {
        $path = self::initializingAFile($fileName);

        $response = file_get_contents($from);
        file_put_contents($path, $response);
    }

    private static function initializingAFile($fileName)
    {
        chmod(self::PATH_TO_STORAGE, 0777);
        
        return  self::PATH_TO_STORAGE . $fileName .".jpg";
    }
}
