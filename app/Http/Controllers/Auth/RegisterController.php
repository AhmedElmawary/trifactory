<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Question;
use App\Answervalue;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Events\UserRegistered;
use Illuminate\Auth\Events\Registered;
use Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $question = Question::where('question_text', 'like', '%club%')->first();
        $clubs = Answervalue::where('question_id', $question->id)->get();
        $nationalities = \countries();
        unset($nationalities['il']);
        if (Request::is('api*') || Request::wantsJson()) {
            return response()->json([
                'nationalities' => $nationalities,
                'clubs' => $clubs
            ]);
        } else {
            return view('auth.register', [
                'nationalities' => $nationalities,
                'clubs' => $clubs
            ]);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['years'] = range(1930, date('Y'));
        if (isset($data['club']) && preg_match("/other/i", $data['club'])) {
            return Validator::make($data, [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
                'nationality' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'year_of_birth' => ['required', 'digits:4', 'integer', 'min:1930',
                'max:'.(date('Y')-5), 'in_array:years.*'],
                'other_club' => ['required', 'string', 'max:255']
            ]);
        } else {
            return Validator::make($data, [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
                'nationality' => ['required', 'string'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'year_of_birth' => ['required', 'digits:4', 'integer', 'min:1930',
                'max:'.(date('Y')-12), 'in_array:years.*'],
                'club' => ['required', 'string', 'max:255']
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (preg_match("/other/i", $data['club'])) {
            $data['club'] = $data['other_club'];
        }
        $user = User::create([
            'name' => $data['firstname'] . ' ' . $data['lastname'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'nationality' => $data['nationality'],
            'password' => Hash::make($data['password']),
            'year_of_birth' => (int) $data['year_of_birth'],
            'club' => $data['club']
        ]);

        $event = new UserRegistered($user);
        event($event);

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(\Illuminate\Http\Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
    
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(\Illuminate\Http\Request $request, $user)
    {
        if (Request::is('api*') || Request::wantsJson()) {
            $user->generateToken();
            return response()->json(['data' => $user->toArray()], 201);
        }
    }
}
