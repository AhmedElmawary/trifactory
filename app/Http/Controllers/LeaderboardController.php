<?php

namespace App\Http\Controllers;

use DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        if(\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
        $leaderboardMale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'M')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->paginate(25);

        $leaderboardFemale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'F')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->paginate(25);

        $leaderboardClub = \DB::table('leaderboard_data')
            ->select('points', 'club', \DB::raw('SUM(points) as total_points'))
            ->whereNotIn('club', ['NA', 'Independent', 'Other', 'I am an independent athlete.'])
            ->orderByRaw('total_points desc')
            ->groupBy('club')
            ->paginate(25);

        $data = [
            'leaderboardMale' => $leaderboardMale,
            'leaderboardFemale' => $leaderboardFemale,
            'leaderboardClub' => $leaderboardClub,
        ];
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json(['data' => $data]);
        } else {
            return view('leaderboard', $data);
        }
    }
}
