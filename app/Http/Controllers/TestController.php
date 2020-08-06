<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use App\Helpers\GetGuzzleClient;
use App\Helpers\JsonHelper;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $new_token = $user->generateToken();
      
        return response()->json([$user, "new_token" => $new_token], 200);
    }

    public function done()
    {
        \DB::table('test')->insert(
            ["id"=>"Default"],
            ["cowpay_response" => JsonHelper::toJsonObject(request()->all())]
        );
    }
}
