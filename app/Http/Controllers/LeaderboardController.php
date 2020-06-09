<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\LeaderboardData;
use App;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }

        $years = [];
        if ($request->input('year') != "") {
            $year = $request->input('year');
        } else {
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
        }

        $leaderboardMale = \DB::table('leaderboard_data')
            ->select(
                'name',
                'points',
                'country_code',
                'category',
                'gender_position',
                'category_position',
                'club',
                \DB::raw('SUM(points) as total_points')
            )
            ->where('gender', 'M')
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%' . $request->input('category') . '%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
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
                'category_position',
                'club',
                \DB::raw('SUM(points) as total_points')
            )
            ->where('gender', 'F')
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%' . $request->input('category') . '%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->paginate(25);

        $leaderboardClub = \DB::table('leaderboard_data')
            ->select('points', 'club', \DB::raw('SUM(points) as total_points'))
            ->whereNotIn('club', ['NA', 'Independent', 'Other', 'I am an independent athlete.', ' '])
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('club')
            ->paginate(25);

        $male_clubs = \DB::table('leaderboard_data')
            ->select('club')
            ->where('gender', 'M')
            ->WhereNotNull('club')
            ->Where(\DB::raw('TRIM(club)'), '!=', '')
            ->groupBy('club')
            ->pluck('club');
        $male_categories = \DB::table('leaderboard_data')
            ->select('category')
            ->where('gender', 'M')
            ->where('category', 'regexp', '[Mm][Uu]?[0-9]+(-[0-9]+)?')
            ->groupBy('category')
            ->pluck('category');
        $female_clubs = \DB::table('leaderboard_data')
            ->select('club')
            ->where('gender', 'F')
            ->WhereNotNull('club')
            ->Where(\DB::raw('TRIM(club)'), '!=', '')
            ->groupBy('club')
            ->pluck('club');
        $female_categories = \DB::table('leaderboard_data')
            ->select('category')
            ->where('gender', 'F')
            ->where('category', 'regexp', '[Ff][Uu]?[0-9]+(-[0-9]+)?')
            ->groupBy('category')
            ->pluck('category');
        $clubs = \DB::table('leaderboard_data')
            ->select('club')
            ->WhereNotNull('club')
            ->Where(\DB::raw('TRIM(club)'), '!=', '')
            ->groupBy('club')
            ->pluck('club');

        $data = [
            'leaderboardMale' => $leaderboardMale,
            'leaderboardFemale' => $leaderboardFemale,
            'leaderboardClub' => $leaderboardClub,
            'male_clubs' => $male_clubs,
            'male_categories' => $male_categories,
            'female_clubs' => $female_clubs,
            'female_categories' => $female_categories,
            'clubs' => $clubs,
            'years' => $years
        ];
        if (\Request::is('api*')) {
            return response()->json(['data' => $data]);
        } else {
            return view('leaderboard', $data);
        }
    }

    public function indexWithYear(Request $request, $year)
    {
        $paginationCount = 25;
        if ($request['home']) {
            $paginationCount = 10;
        }
        $allEvents = \DB::select(
            "SELECT DISTINCT YEAR(created_at) AS year FROM leaderboard_data ORDER BY YEAR(created_at) DESC"
        );
        $years = [];
        foreach ($allEvents as $event) {
            $years[] = $event->year;
        }
        session()->put("year", $year);
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
                'category_position',
                'club',
                \DB::raw('SUM(points) as total_points')
            )
            ->where('gender', 'M')
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%' . $request->input('category') . '%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->paginate($paginationCount);

            $leaderboardMaleFull = \DB::table('leaderboard_data')
            ->select(
                'id',
                'name',
                'points',
                'country_code',
                'category',
                'gender_position',
                'category_position',
                'club',
                \DB::raw('SUM(points) as total_points')
            )
            ->where('gender', 'M')
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%' . $request->input('category') . '%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('name');
            
            $this->sortLeaderboardData($leaderboardMaleFull->get());

            $leaderboardFemale = \DB::table('leaderboard_data')
            ->select(
                'name',
                'points',
                'country_code',
                'category',
                'gender_position',
                'category_position',
                'club',
                \DB::raw('SUM(points) as total_points')
            )
            ->where('gender', 'F')
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%' . $request->input('category') . '%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('name')
            ->paginate($paginationCount);

            $leaderboardFemaleFull = \DB::table('leaderboard_data')
            ->select(
                'id',
                'name',
                'points',
                'country_code',
                'category',
                'gender_position',
                'category_position',
                'club',
                \DB::raw('SUM(points) as total_points')
            )
            ->where('gender', 'F')
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%' . $request->input('category') . '%');
                }
                if ($request->input('gender_position') != "") {
                    $query->where('gender_position', 'like', $request->input('gender_position'));
                }
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('name');

            
            $this->sortLeaderboardData($leaderboardFemaleFull->get());

        $leaderboardClub = \DB::table('leaderboard_data')
            ->select('points', 'club', \DB::raw('SUM(points) as total_points'))
            ->whereNotIn('club', ['NA', 'Independent', 'Other', 'I am an independent athlete.', ' '])
            ->where('club', 'not like', '%Independent%')
            ->where('created_at', 'like', '%' . $year . '%')
            ->where(function ($query) use ($request) {
                if ($request->input('club') != "") {
                    $query->where('club', 'like', '%' . $request->input('club') . '%');
                }
            })
            ->orderByRaw('total_points desc')
            ->groupBy('club')
            ->paginate($paginationCount);

        $male_clubs = \DB::table('leaderboard_data')
            ->select('club')
            ->where('gender', 'M')
            ->groupBy('club')
            ->pluck('club');
        $male_categories = \DB::table('leaderboard_data')
            ->select('category')
            ->where('gender', 'M')
            ->groupBy('category')
            ->pluck('category');
        $female_clubs = \DB::table('leaderboard_data')
            ->select('club')
            ->where('gender', 'F')
            ->groupBy('club')
            ->pluck('club');
        $female_categories = \DB::table('leaderboard_data')
            ->select('category')
            ->where('gender', 'F')
            ->groupBy('category')
            ->pluck('category');
        $clubs = \DB::table('leaderboard_data')
            ->select('club')
            ->groupBy('club')
            ->pluck('club');

        $data = [
            'leaderboardMale' => $leaderboardMale,
            'leaderboardFemale' => $leaderboardFemale,
            'leaderboardClub' => $leaderboardClub,
            'male_clubs' => $male_clubs,
            'male_categories' => $male_categories,
            'female_clubs' => $female_clubs,
            'female_categories' => $female_categories,
            'clubs' => $clubs,
            'years' => $years
        ];
        if (\Request::is('api*')) {
            return response()->json(['data' => $data]);
        } else {
            return view('leaderboard', $data);
        }
        // return response()->json(['data' => $data]);
    }

    public function details(Request $request)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
        $recordDetails = LeaderboardData::with('race.event')
            ->where(function ($query) use ($request) {
                if ($request->input('name') != "") {
                    $query->where('name', 'like', '%' . $request->input('name') . '%');
                }
                if ($request->input('category') != "") {
                    $query->where('category', 'like', '%' . $request->input('category') . '%');
                }
                if ($request->input('club') != "") {
                    $query->where('club', 'like', $request->input('club'));
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

    public function sortLeaderboardData($data)
    {
        $i=1;

        if (request()->club == null && request()->name == null && request()->category == null) {
                return;
        } elseif (request()->category !== null) {
            foreach ($data as $key => $value) {
                if ($key < count($data) -1) {
                    if ($value->total_points != $data[$key+1]->total_points   &&  ! empty(request()->category)) {
                        $row = App\LeaderboardData::find($value->id);
                        $row_1 = App\LeaderboardData::find($data[$key+1]->id);
                        $row->category_position = $i++;
                        $row_1->category_position = $i;
                        $row_1->save();
                        $row->save();
                    }
                    if ($value->total_points == $data[$key+1]->total_points &&  ! empty(request()->category)) {
                        $row = App\LeaderboardData::find($value->id);
                        $row_1 = App\LeaderboardData::find($data[$key+1]->id);
                        $row->category_position = $i;
                        $row_1->category_position = $i;
                        $row->save();
                        $row_1->save();
                    }
                }
            }
        }
    }
}