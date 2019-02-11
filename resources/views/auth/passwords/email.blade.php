@extends('layouts.app', ['body_class' => 'sign-in-view'])

@section('content')

<!-- Start Content -->
<div class="container">
     @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    <section class="login-section no-height">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <h3>Reset Password</h3>
                    <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="input-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn dark btn-clear float-right mt-2">Reset</button>
                </form>
            </div>
        </div>
    </section>
</div>             
@endsection
