@extends('layouts.app', ['body_class' => 'sign-in-view']) 
@section('title', 'Reset Password')
@section('content')
<div class="container">
    <section class="login-section no-height">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h3>Reset Password</h3>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}" />

                    <div class="input-group">
                        <input
                            id="email"
                            type="email"
                            placeholder="E-Mail"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            name="email"
                            value="{{ $email ?? old('email') }}"
                            required
                            autofocus
                        />

                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="input-group">
                        <input
                            id="password"
                            type="password"
                            placeholder="Password"
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
                            id="password-confirm"
                            type="password"
                            placeholder="Password Confirm"
                            class="form-control"
                            name="password_confirmation"
                            required
                        />
                    </div>

                    <button type="submit" class="btn dark btn-clear float-right mt-2">Reset Password</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
