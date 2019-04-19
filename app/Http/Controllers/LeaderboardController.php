<?php

namespace App\Http\Controllers;

use DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboardMale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'M')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->simplePaginate(25);

        $leaderboardFemale = \DB::table('leaderboard_data')
            ->select('name', 'points', 'country_code', 'category', 'club', \DB::raw('SUM(points) as total_points'))
            ->where('gender', 'F')
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->simplePaginate(25);

        $leaderboardClub = \DB::table('leaderboard_data')
            ->select('points', 'club', \DB::raw('SUM(points) as total_points'))
            ->orderByRaw('total_points desc')
            ->groupBy('club')
            ->simplePaginate(25);

        $data = [
            'leaderboardMale' => $leaderboardMale,
            'leaderboardFemale' => $leaderboardFemale,
            'leaderboardClub' => $leaderboardClub,
        ];

        return view('leaderboard', $data);
    }
}
