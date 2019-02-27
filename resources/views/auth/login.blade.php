@extends('layouts.app', ['body_class' => 'sign-in-view'])

@section('content')
<!-- Start Content -->
<div class="container">
    <section class="login-section no-height">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h3>Already a Member?</h3>
                    <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <input id="email" placeholder="E-mail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="input-group">
                        <input placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <a class="dark float-left mt-2" href="{{ route('password.request') }}">Forgot Password?</a>
                    <a class="dark float-right mt-2" href="{{ route('register') }}">Sign up</a>
                    <span class="float-right mt-2">&nbsp;|&nbsp;</span>
                    <button type="submit" class="btn dark btn-clear float-right mt-2">Login</button>
                    
                </form>
            </div>
        </div>
    </section>
</div>

<!-- End Content -->
@endsection