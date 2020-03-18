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
        $upcomingEvents = Event::with('eventimages')->upcomming()->published()->get();
        $comingSoonEvents = Event::with('eventimages')->comingsoon()->get();
        $allEvents = \DB::select(
            "SELECT DISTINCT YEAR(created_at) AS year FROM leaderboard_data ORDER BY YEAR(created_at) DESC"
        );
        $years = [];
        foreach ($allEvents as $event) {
            $years[] = $event->year;
        }
        if (!session()->get("year")) {
            session()->put("year", $years[0]);
        }

        $year = session()->get("year", $years[0]);

        $leaderboardMale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'M')
            ->where('created_at', 'like', '%' . $year . '%')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->limit(10)
            ->get();

        $leaderboardFemale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'F')
            ->where('created_at', 'like', '%' . $year . '%')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->limit(10)
            ->get();

        $leaderboardClub = \DB::table('leaderboard_data')
            ->select('points', 'club', \DB::raw('SUM(points) as total_points'))
            ->whereNotIn('club', ['NA', 'Independent', 'Other', 'I am an independent athlete.', ' '])
            ->where('created_at', 'like', '%' . $year . '%')
            ->orderByRaw('total_points desc')
            ->groupBy('club')
            ->limit(10)
            ->get();

        $data = [
            'gallery' => $gallery,
            'upcomingEvents' => $upcomingEvents,
            'leaderboardMale' => $leaderboardMale,
            'leaderboardFemale' => $leaderboardFemale,
            'leaderboardClub' => $leaderboardClub,
            'comingSoonEvents' => $comingSoonEvents,
            'years' => $years
        ];
        if (\Request::is('api*') || \Request::wantsJson()) {
            foreach ($data['upcomingEvents'] as $event) {
                $event['formatted_date'] = \Carbon\Carbon::parse($event->event_start)->format('j') .
                    (($event->event_start != $event->event_end) ? ' - ' .
                        \Carbon\Carbon::parse($event->event_end)->format('j M Y') :
                        \Carbon\Carbon::parse($event->event_end)->format(' M Y'));
            }
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
