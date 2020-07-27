<?php

namespace App\Http\Controllers\Auth;

use Request;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\FacebookHelper;
use App\Helpers\JsonHelper;
use App\Helpers\DownloaderHelper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(\Illuminate\Http\Request $request)
    {
        $data = [];
        if ($request->get('verify')) {
            $data['message'] = 'Please verify your email by clicking the link in the verification email.';
        }

        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }
        
        return view('auth.login', $data);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(\Illuminate\Http\Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if (Request::is('api*') || Request::wantsJson()) {
                $user = $this->guard()->user();
                $user->generateToken();
                return JsonHelper::toJsonObject($user);
            } else {
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        if (Request::is('api*') || Request::wantsJson()) {
            $user = \Auth::guard('api')->user();
            if ($user) {
                $user->api_token = null;
                $user->save();
            }
            return response()->json(['success' => true, 'data' => 'User logged out.'], 200);
        } else {
            $this->guard()->logout();
            $request->session()->invalidate();
            return $this->loggedOut($request) ?: redirect('/');
        }
    }
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     * using Laravel\Socialite\Contracts\User to retrive the user
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($token = null)
    {
        $this->isEmpty($token);

        $userFb = Socialite::driver('facebook')
        ->fields(FacebookHelper::getHelperFields())
        ->userFromToken($token);
        $this->isEmpty($userFb);

        $user = \App\User::where("email", $userFb->getEmail())
            ->orWhere("fb_id", $userFb->getId())
            ->first();
        if ($user == null) {
            DownloaderHelper::downloadFileToStorage(
                $userFb->avatar_original,
                $userFb->getId()
            );

            return json_encode($userFb);
        }
        $user->fb_id = $userFb->getId();
        $user->profile_image = $userFb->getId().".jpg";
        $user->save();
        $user->generateToken();
        return JsonHelper::toJsonObject($user);
    }

    private function isEmpty($object) :void
    {
        if ($object == null) {
            throw new Exception("null type Exception");
        }
    }
}
