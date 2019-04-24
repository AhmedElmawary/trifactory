@extends('layouts.app', ['body_class' => 'sign-in-view'])
@section('title', 'Verify')
@section('content')
<div class="container">
    <section class="login-section no-height">
       <div class="row">
            <div class="col-lg-7 offset-lg-3 text-center">
                <h3>{{ __('Verify Your Email Address') }}</h3>
                    <div>
                    @if (session('resent'))
                        <div class="alert alert-info" role="alert">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <h6>{{ __('Before proceeding, please check your email for a verification link.') }}</h6>
                    {{ __('If you did not receive the email') }}, <a class="dark mt-2" href="{{ route('verification.resend') }}">{{ __('click here to resend the verification email') }}</a>.
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
