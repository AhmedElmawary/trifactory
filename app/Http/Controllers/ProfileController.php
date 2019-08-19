<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Question;
use App\Answervalue;
use App\Ticket;
use Illuminate\Support\Facades\Hash;
use App\User;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (\Request::is('api*') || \Request::wantsJson()) {
            $this->middleware(['auth:api'])->except(['getUser', 'validatePhone']);
        } else {
            $this->middleware('auth');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $data['past_events'] = \App\LeaderboardData::with('race.event')->where('email', $user->email)->get();
            $data['upcoming_events'] = \App\UserRace::with('race.event', 'ticket')
                ->whereHas('race.event', function ($query) {
                    $query->where('event_start', '>', \Carbon\Carbon::today()->toDateTimeString());
                })
                ->where('user_id', $user->id)
                ->get();
            $data['points'] = \App\LeaderboardData::where('email', $user->email)->sum('points');
            $data['user'] = $user;
            $data['profile_image'] = '/images/placeholder.svg';
            $question = Question::where('question_text', 'like', '%club%')->first();
            $data['clubs'] = Answervalue::where('question_id', $question->id)->get();
            if ($user->profile_image) {
                $data['profile_image'] = '/storage/profile_images/' . $user->profile_image;
            }
        }
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return view('profile', $data);
        }
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function validatePhone()
    {
        $phone_exist = User::where('phone', $_GET['phone'])->first();
        \Log::info($phone_exist);
        \Log::info($_GET['phone']);
        if ($phone_exist) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            return redirect('/profile')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json(['status' => 200, 'message' => 'Password updated successfully', 'success' => true]);
        } else {
            return redirect('/profile');
        }
    }

    public function update(Request $request)
    {
        $request['years'] = range(1930, date('Y'));
        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,'.Auth::user()->id],
            'phone' => ['required', 'string', 'min:11', 'max:11', 'unique:users,email,'.Auth::user()->id],
            'year_of_birth' => ['required', 'digits:4', 'integer', 'min:1930',
            'max:'.(date('Y')-5), 'in_array:years.*'],
        ]);

        if ($validator->fails()) {
            return redirect('/profile')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->club == 'Other') {
            $request->club = $request->other_club;
        }

        $user = Auth::user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->year_of_birth = $request->year_of_birth;
        $user->club = $request->club;
        $user->save();

        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json([
                'status' => 200,
                'message' => 'Profile updated successfully',
                'success' => true,
                'data' => $user
            ]);
        } else {
            return redirect('/profile');
        }
    }

    public function image(Request $request)
    {
        if ($request->hasFile('profile_image')) {
            // Get filename with extension
            $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = 'profile_image_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('profile_image')->storeAs('public/profile_images', $fileNameToStore);

            $user = Auth::user();
            $user->profile_image = $fileNameToStore;
            $user->save();
        }

        return redirect()->action(
            'ProfileController@index'
        );
    }
}
