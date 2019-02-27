@extends('layouts.app', ['body_class' => 'home-view'])
@section('title', 'Payment')
@section('content')
<br>
<section class="hero-section d-flex justify-content-center no-separator no-padding">
    <iframe 
        frameborder="0"
        style="width:100%;" 
        src="https://accept.paymobsolutions.com/api/acceptance/iframes/{{config('paymob.iframe_id')}}?payment_token={{$paymentKey->token}}">
    </iframe>
</section>
@endsection

