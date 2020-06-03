@extends('layouts.app', ['body_class' => 'sign-in-view']) 
@section('title', 'Sign up')
@section('content')
<script>
    function onSignUp() {
        fbq('track', 'CompleteRegistration');
    }
</script>
<div class="container">
    <section class="register-section no-height no-separator">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h3>Sign Up Now</h3>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group">
                        <input
                            placeholder="First Name"
                            id="firstname"
                            type="text"
                            class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                            name="firstname"
                            value="{{ old('firstname') }}"
                            required
                            autofocus
                        />

                        @if ($errors->has('firstname'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('firstname') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-group">
                            <input
                                placeholder="Last Name"
                                id="lastname"
                                type="text"
                                class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                name="lastname"
                                value="{{ old('lastname') }}"
                                required
                                autofocus
                            />
    
                            @if ($errors->has('lastname'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('lastname') }}</strong>
                            </span>
                            @endif
                        </div>

                    <div class="input-group">
                        <input
                            placeholder="E-mail"
                            id="email"
                            type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            name="email"
                            value="{{ old('email') }}"
                            required
                        />

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>
                                @if (preg_match("/taken/i", $errors->first('email')))
                                The email has already been taken or someone has previously <br>registered a ticket for you.<br>Please reset your password from <a href="{{url("password/reset")}}">here</a>
                                @else
                                {{$errors->first('email')}}
                                @endif
                        </span>
                        @endif
                    </div>

                    <div class="input-group">
                        <input
                            placeholder="Phone"
                            id="phone"
                            type="text"
                            class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                            name="phone"
                            value="{{ old('phone') }}"
                            required
                        />

                        @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-group">
                        <select style="margin-top:20px;" class="custom-select" name="gender" required>
                            <option disabled value="" selected>Gender</option>

                            @foreach($gender as $type)
                            <option value="{{$type['value']}}">{{$type['label']}}</option>
                            @endforeach

                        </select>

                        @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                        @endif
                    </div>
                    
                    <div class="input-group">
                        <select style="margin-top:20px;" class="custom-select" name="nationality" required>
                            <option disabled value="" selected>Nationality</option>

                            @foreach($nationalities as $nationality)
                            <option value="{{$nationality['iso_3166_1_alpha2']}}">{{$nationality['name']}}</option>
                            @endforeach

                        </select>

                        @if ($errors->has('nationality'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('nationality') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-group">
                            <select style="margin-top:20px;" class="custom-select" name="year_of_birth" required>
                                    <option disabled value="" selected>Year of birth</option>
                                    @for ($i = 1930; $i <= date('Y')-5; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                            </select>
    
                            @if ($errors->has('year_of_birth'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('year_of_birth') }}</strong>
                            </span>
                            @endif
                    </div>

                    <div class="input-group">
                            <select style="margin-top:20px;" class="custom-select clubs" name="club" required>
                                    <option disabled value="" selected>Club</option>
                                    @foreach ($clubs as $club)
                                        <option value="{{$club->value}}">{{$club->value}}</option>
                                    @endforeach
                            </select>
    
                            @if ($errors->has('club'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('club') }}</strong>
                            </span>
                            @endif
                    </div>
                    <div class="input-group other_club">
                            <input
                                placeholder="Please specify..."
                                id="other_club"
                                type="text"
                                class="form-control{{ $errors->has('other_club') ? ' is-invalid' : '' }}"
                                name="other_club"
                                value="{{ old('other_club') }}"
                                autofocus
                            />
    
                            @if ($errors->has('other_club'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('other_club') }}</strong>
                            </span>
                            @endif
                    </div>

                    
                    <div class="input-group">
                        <input
                            placeholder="Password"
                            id="password"
                            type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            name="password"
                            required
                        />

                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-group">
                        <input
                            placeholder="Password confirm"
                            id="password-confirm"
                            type="password"
                            class="form-control"
                            name="password_confirmation"
                            required
                        />
                    </div>

                    <button onclick="onSignUp()" type="submit" class="btn btn-dark light mt-3">
                        Signup
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
