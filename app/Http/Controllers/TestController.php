<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $new_token = $user->generateToken();
        $merchant_reference_id = openssl_random_pseudo_bytes(30)
        .random_int(2, PHP_INT_MAX).random_bytes(9)." at".date("d-m-Y_H:I:s");
        
        $string = "0123456789asdfghjklzxcvbnmqwertyuiopASDFGHJKLZXCVBNMQWERTYUIOP[];'!@#$%^&?><";
        $len = strlen($string);
        $i=0;
        $hash = '';
        while ($i < 1000) {
            $hash.= $string[rand(0, $len-1)];
            $string = str_shuffle($string);
            $i++;
        }
        $prifex = StringHelper::generateHashWithTimeZoneFor(30);
        dump(uniqid($prifex, true));
        dump(StringHelper::generateHashFor(30));
        dump($hash);
        dump($merchant_reference_id);
        return response()->json([$user, "new_token" => $new_token], 200);
    }
}
