<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Gallery;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $gallery = Gallery::latest('created_at')->with('galleryimage')->first();
        $upcomingEvents = Event::upcomming()->published()->get();

        $data = [
            'gallery' => $gallery,
            'upcomingEvents' => $upcomingEvents,
        ];
        
        return view('home', $data);
    }
}
