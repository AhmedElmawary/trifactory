<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails {
        sendResetLinkResponse as protected successResponse;
        sendResetLinkFailedResponse as protected failedResponse;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response(['message' => trans($response)], 200);
        } else {
            return $this->successResponse($request, $response);
        }
    }


    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response(['error' => trans($response)], 400);
        } else {
            return $this->failedResponse($request, $response);
        }
    }
}
