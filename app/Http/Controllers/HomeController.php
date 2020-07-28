<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use App\Gallery;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (\Request::is('api*') || \Request::wantsJson()) {
            // $this->middleware(['auth:api', 'verified']);
        } else {
            // $this->middleware('auth');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return response()->json(User::find(1), 200);
    }
}
