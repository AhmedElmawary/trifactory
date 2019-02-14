@extends('layouts.app', ['body_class' => 'sign-in-view']) @section('content')
<div class="container">
    <section class="register-section no-height no-separator">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h3>Signup Now</h3>
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
                            placeholder="E-Mail"
                            id="email"
                            type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            name="email"
                            value="{{ old('email') }}"
                            required
                        />

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
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

                    <button type="submit" class="btn btn-dark light mt-3">
                        Signup
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
