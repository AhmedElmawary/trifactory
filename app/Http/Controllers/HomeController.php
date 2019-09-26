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
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
        $gallery = Gallery::latest('created_at')->with('galleryimage')->first();
        $upcomingEvents = Event::upcomming()->published()->get();

        $leaderboardMale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'M')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->limit(5)
            ->get();

        $leaderboardFemale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'F')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->limit(5)
            ->get();

        $leaderboardClub = \DB::table('leaderboard_data')
            ->select('points', 'club', \DB::raw('SUM(points) as total_points'))
            ->whereNotIn('club', ['NA', 'Independent', 'Other', 'I am an independent athlete.'])
            ->orderByRaw('total_points desc')
            ->groupBy('club')
            ->limit(5)
            ->get();

        $data = [
            'gallery' => $gallery,
            'upcomingEvents' => $upcomingEvents,
            'leaderboardMale' => $leaderboardMale,
            'leaderboardFemale' => $leaderboardFemale,
            'leaderboardClub' => $leaderboardClub,
        ];
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return view('home', $data);
        }
    }

    public function test()
    {
        $user = \Auth::user();

        $upcoming = \App\UserRace::with('race.event')
            ->whereHas('race.event', function ($query) {
                $query->where('event_start', '>', \Carbon\Carbon::today()->toDateTimeString());
            })
            ->where('user_id', $user->id)
            ->get();

        dd($upcoming);
    }
}
