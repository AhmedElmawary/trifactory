<?php

namespace App\Http\Controllers;

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

    public function test()
    {
        $promocode = \App\Promocode::where('code', 'TF20%')
                   ->where('published', 'YES')
                   ->whereHas('races', function ($query) {
                       $query->where('race_id', '=', 2);
                   })->first();

        dd($promocode);
    }
}
