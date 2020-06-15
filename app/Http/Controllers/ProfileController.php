<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Question;
use App\Answervalue;
use App\Order;
use App\Ticket;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\QuestionAnswer;
use App\UserRace;
use App\Events\RaceTicketQrCode;

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
            $this->middleware(['auth:api'])->except(['validatePhone']);
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
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
        if ($user) {
            $data['past_events'] = \App\LeaderboardData::with('race.event')->where('email', $user->email)->get();
            foreach ($data['past_events'] as $past) {
                $leaderboard_by_gender = \DB::table('leaderboard_data')
                    ->select(
                        'name',
                        'points',
                        'country_code',
                        'category',
                        'gender_position',
                        'club',
                        'email',
                        \DB::raw('SUM(points) as total_points')
                    )
                    ->where('gender', $past['gender'])
                    ->where('race_id', $past['race_id'])
                    ->orderByRaw('total_points desc')
                    ->groupBy('name')
                    ->get();
                $rank = 0;
                $found = false;
                foreach (json_decode($leaderboard_by_gender, true) as $record) {
                    $rank++;
                    if ((stripos($record['email'], strtolower($user->email)) !== false)) {
                        break;
                    }
                }
                $past['gender_rank'] = $rank;

                $leaderboard_by_category = \DB::table('leaderboard_data')
                    ->select(
                        'name',
                        'points',
                        'country_code',
                        'category',
                        'gender_position',
                        'club',
                        'email',
                        \DB::raw('SUM(points) as total_points')
                    )
                    ->where('category', $past['category'])
                    ->where('race_id', $past['race_id'])
                    ->orderByRaw('total_points desc')
                    ->groupBy('name')
                    ->get();
                $rank = 0;
                $found = false;
                foreach (json_decode($leaderboard_by_category, true) as $record) {
                    $rank++;
                    if ((stripos($record['email'], strtolower($user->email)) !== false)) {
                        break;
                    }
                }
                $past['category_rank'] = $rank;
            }

            $data['upcoming_events'] = \App\UserRace::with(
                'race.event',
                'ticket',
                'order',
                'questionanswer',
                'questionanswer.question',
                'questionanswer.question.answertype',
                'questionanswer.question.answervalue'
            )
                ->with(['ticket.race.ticket' => function ($query) {
                    $query->where('published', 'yes');
                }])
                ->whereHas('race.event', function ($query) {
                    $query->where('event_start', '>', \Carbon\Carbon::today()->toDateTimeString());
                })
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->orWhere('participant_user_id', $user->id);
                })
                ->whereHas('order', function ($query) {
                    $query->where('success', 'true');
                })
                ->get();
            foreach ($data['upcoming_events'] as $event) {
                $event['participant_user'] = \App\User::find($event->participant_user_id);
                $event->race->event['total_refund'] = ($event->race->event->event_end >= date('Y-m-d'));
            }
            if (isset($user->gender)) {
                $user->gender = ucwords(trim($user->gender));
                \DB::table("users")->where("id", $user->id)->update(["gender" => $user->gender]);
            }
            $user->gender = ucwords(trim($user->gender));
            $data['user'] = $user;
            $data['profile_image'] = '/images/placeholder.svg';
            $question = Question::where('question_text', 'like', '%club%')->first();
            $data['clubs'] = Answervalue::where('question_id', $question->id)->get();
            if ($user->profile_image) {
                $data['profile_image'] = '/storage/profile_images/' . $user->profile_image;
            }
            $leaderboard_data = \App\LeaderboardData::where('email', $user->email)->orderBy('id', 'desc');
            $data['points'] = $leaderboard_data->sum('points');

            if ($leaderboard_data->exists()) {
                $leaderboard_by_gender = \DB::table('leaderboard_data')
                    ->select(
                        'name',
                        'points',
                        'country_code',
                        'category',
                        'gender_position',
                        'club',
                        'email',
                        \DB::raw('SUM(points) as total_points')
                    )
                    ->where('gender', $leaderboard_data->first()['gender'])
                    ->orderByRaw('total_points desc')
                    ->groupBy('name')
                    ->get();
                $rank = 0;
                $found = false;
                foreach (json_decode($leaderboard_by_gender, true) as $record) {
                    $rank++;
                    if ((stripos($record['email'], strtolower($user->email)) !== false)) {
                        break;
                    }
                }
                $data['leaderboard_gender_rank'] = $rank;
            } else {
                $data['leaderboard_gender_rank'] = 0;
            }

            if ($leaderboard_data->exists()) {
                $leaderboard_by_category = \DB::table('leaderboard_data')
                    ->select(
                        'name',
                        'points',
                        'country_code',
                        'category',
                        'gender_position',
                        'club',
                        'email',
                        \DB::raw('SUM(points) as total_points')
                    )
                    ->where('category', $leaderboard_data->first()['category'])
                    ->orderByRaw('total_points desc')
                    ->groupBy('name')
                    ->get();
                $rank = 0;
                $found = false;
                foreach (json_decode($leaderboard_by_category, true) as $record) {
                    $rank++;
                    if ((stripos($record['email'], strtolower($user->email)) !== false)) {
                        break;
                    }
                }
                $data['leaderboard_category_rank'] = $rank;
            } else {
                $data['leaderboard_category_rank'] = 0;
            }

            $nationalities = \countries();
            unset($nationalities['il']);
            $data['countries'] = json_encode($nationalities);
            $data['credit'] = $user->credit->sum('amount');
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
        $currentPhone = $_GET['phone'];
        $currentEmail = $_GET['email'];
        // view the cart items
        $items = [];
        if (!(\Request::is('api*'))) {
            $userId = \Auth::user()->id;
            $items = \Cart::session($userId)->getContent();
        }
        $email_exist = User::where('email', isset($_GET['email']) ? $_GET['email'] : '')->first();
        if ($email_exist) {
            return 'false';
        }
        if (!isset($_GET['email'])) {
            return 'false';
        }
        $phone_exist = User::where('phone', $_GET['phone'])->first();
        if ($phone_exist) {
            return 'true';
        }

        foreach ($items as $row) {
            if (($row->attributes["E-mail"] != trim($currentEmail))
                && ($row->attributes->Phone == trim($currentPhone))
            ) {
                return 'true';
            }
        }

        return 'false';
    }

    public function resendqrcode($event)
    {
        $userRace = UserRace::find($event);
        $participantTicketId = $userRace->participant_ticket_id;
        $participantUserId = $userRace->participant_user_id;
        $registeredUserId = $userRace->user_id;
        $participantUser = User::find($userRace->participant_user_id);
        $userTicket = null;
        $fromUser = null;
        $order = Order::find($userRace->order_id);
        $meta = json_decode($order->meta);
        foreach ($meta as $ticketId => $ticket) {
            if ($ticketId !== 'credit' && $ticketId !== 'voucher' && $ticketId == $participantTicketId) {
                $userTicket = $ticket;
                break;
            }
        }

        $self = false;
        $other = false;
        if ($participantUserId === $registeredUserId) {
            $self = true;
        } else {
            $other = true;
            $fromUser = User::find($registeredUserId);
        }
        event(
            new RaceTicketQrCode(
                $participantTicketId,
                $participantUser,
                $userTicket,
                $self,
                $other,
                $fromUser,
                false
            )
        );
        return redirect()->back();
    }

    public function password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            if (\Request::is('api*')) {
                return response()->json([
                    'message' => $validator->errors()
                ]);
            } else {
                return redirect('/profile')
                    ->withErrors($validator)
                    ->withInput();
            }
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
            'email' => ['string', 'email', 'max:255', 'unique:users,email,' . Auth::user()->id],
            'phone' => ['string', 'min:11', 'max:11', 'unique:users,phone,' . Auth::user()->id],
            'year_of_birth' => [
                'required', 'digits:4', 'integer', 'min:1930',
                'max:' . (date('Y') - 5), 'in_array:years.*'
            ],
        ]);

        if ($validator->fails()) {
            if (\Request::is('api*')) {
                return response()->json([
                    'message' => $validator->errors()
                ]);
            } else {
                return redirect('/profile')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if ($request->club == 'Other') {
            $request->club = $request->other_club;
        }

        $user = Auth::user();
        $user->firstname = $request->firstname ?? $user->firstname;
        $user->lastname = $request->lastname ?? $user->firstname;
        $user->name = $user->firstname . ' ' . $user->lastname;
        $user->email = $request->email ?? $user->email;
        $user->phone = $request->phone ?? $user->phone;
        $user->year_of_birth = $request->year_of_birth;
        $user->club = $request->club ?? $user->club;
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

    public function updateUserRaceAnswers(Request $request)
    {
        // $user = Auth::user();
        // $userrace_id = $request->userrace->id;
        // $qa = QuestionAnswer::where('userrace_id', $userrace_id);
        // if (!stripos($request->userrace->race->name, 'relay')) {}
        \Log::info($request->all());
        foreach ($request->all() as $key => $value) {
            $qa = QuestionAnswer::find($key);
            if (isset($qa)) {
                $qa->answer_value = $value;
                $qa->save();
            }
        }
        return \Redirect::to(\URL::previous() . "#pills-upcoming-events");
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
