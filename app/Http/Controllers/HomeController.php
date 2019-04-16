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

        $leaderboard = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->limit(10)
            ->get();

        $data = [
            'gallery' => $gallery,
            'upcomingEvents' => $upcomingEvents,
            'leaderboard' => $leaderboard,
        ];

        return view('home', $data);
    }

    public function test()
    {

        $leaderboard = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->orderByRaw('points desc')
            ->groupBy('name')
            ->limit(10)
            ->get();

        foreach ($leaderboard as $leader) {
            echo $leader->name;
            echo $leader->points;
            echo '<br>';
        }

        // dd($leaderboard);
    }
}
