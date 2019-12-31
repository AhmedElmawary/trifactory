<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\LeaderboardData;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
        $leaderboardMale = \DB::table('leaderboard_data')
            ->select(
                'name',
                'points',
                'country_code',
                'category',
                'gender_position',
                'club',
                \DB::raw('SUM(points) as total_points')
            )
            ->where('gender', 'M')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%'.$request->input('name').'%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%'.$request->input('category').'%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->paginate(25);

        $leaderboardFemale = \DB::table('leaderboard_data')
        ->select(
            'name',
            'points',
            'country_code',
            'category',
            'gender_position',
            'club',
            \DB::raw('SUM(points) as total_points')
        )
            ->where('gender', 'F')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%'.$request->input('name').'%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%'.$request->input('category').'%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
            })
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
        if (\Request::is('api*')) {
            return response()->json(['data' => $data]);
        } else {
            return view('leaderboard', $data);
        }
    }

    public function details(Request $request)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
        $recordDetails = LeaderboardData::
            with('race.event')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%'.$request->input('name').'%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%'.$request->input('category').'%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
            })
            ->orderByRaw('id desc')
            ->get();
       
        $data = [
            'recordDetails' => $recordDetails
        ];
        if (\Request::is('api*')) {
            return response()->json(['data' => $data]);
        } else {
            return view('leaderboard', $data);
        }
    }
}
