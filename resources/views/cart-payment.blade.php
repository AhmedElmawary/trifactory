@extends('layouts.app', ['body_class' => 'cart-payment-view'])
@section('title', 'Cart Payment')
@section('content')
<!-- Start Content -->
<section class="container no-height no-separator">
    <h3 class="section-title">
        <img
            src="/images/payment-icon.svg"
            alt="payment-icon"
            class="icon"
        />Payment
    </h3>

    <div class="cart-title mt-0">
        <h3>Buy Tickets with Credits</h3>
    </div>
    <div class="cart-points-container col-lg-12">
        <p>
            If you have credit in your wallet, you can now use it to purchase your ticket by clicking on "Use Credit".
        </p>
        <h4 class="mt-3">You have {{$credit}} credits (EGP {{$credit}}) in your wallet</h4>
        <form id="credit-form" method="POST" action="{{ url('/cart/credit') }}">
          @csrf
          <input id="credit" name="credit" value="{{$credit}}" type="hidden">
        
        <button @if($condition) disabled @endif @if(!$credit) disabled @endif type="submit" class="btn btn-dark text-light" id="use_points_button">
            Use Credits
        </button>
        </form>
        <span id="undo_points_button" class="@if($condition) active @endif" >
            We will use your credits to pay for the ticket. Your total cart
            price is @if($condition) now @endif EGP {{$cartTotal}}
            <br />
            <a id="undo-credit" href="#">Undo</a>
        </span>
    </div>
    <div class="cart-title">
        <h3>Add Gift Voucher Code</h3>
    </div>
    <div class="cart-voucher-container col-lg-12">
        <p>You can use gift voucher codes to get discounts on tickets.</p>
        <form id="voucher-form" method="POST" action="{{ url('/cart/voucher') }}">
        <div class="row col-lg-6">
            <div class="input-group">
                  @csrf
                <input
                    id="vode"
                    name="code"
                    value="@if($voucher) {{$voucher->getAttributes()['code']}} @endif"
                    type="text"
                    class="form-control dark-bg"
                    placeholder="Type the Code"
                    @if($voucher) disabled @endif
                />
            </div>
        </div>
        <div class="row col-lg-12">
            
            @if ($errors->has('code'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('code') }}</strong>
                </span>
            @endif

            <button @if($voucher) disabled @endif type="submit" class="btn btn-dark text-light">Use Voucher Code</button>
            <span id="undo_voucher_button" class="@if($voucher) active @endif" >
                Using voucher "@if($voucher) {{$voucher->getAttributes()['code']}} @endif". Your total cart
                price is @if($condition) now @endif EGP {{$cartTotal}}
                <br />
                <a id="undo-voucher" href="#">Undo</a>
            </span>
        </div>
      </form>
    </div>
    <div class="cart-title">
        <h3>Order Details</h3>
    </div>
    <div class="cart-details-container">
        <div class="cart-summary-item">
            Ticket <span class="float-right">Total</span>
        </div>
        @foreach($cartItems as $key => $item)
        <div class="cart-summary-item separator">
            {{$item['attributes']['Ticket Type']}} 
            
            @if(count($item['conditions'])) 
                - with Promocode: {{ $item['conditions'][0]->getAttributes()['code'] }}      
            @endif
            <span class="float-right"> EGP
                @if(count($item['conditions'])) 
                    {{ $item['attributes']['Price'] - $item['conditions'][0]->parsedRawValue }}  
                @else 
                    {{$item['attributes']['Price']}} 
                @endif
            </span>
        </div>
        @endforeach
        <div class="cart-summary-item separator">
            Subtotal <span class="float-right">EGP {{$cartSubTotal}}</span>
        </div>
        @if($condition)
        <div class="cart-summary-item separator">
            {{$condition->getName()}} <span class="float-right">EGP {{$condition->getValue()}}</span>
        </div>
        @endif
        @if($voucher)
        <div class="cart-summary-item separator">
            {{$voucher->getName()}} <span class="float-right">EGP {{$voucher->getValue()}}</span>
        </div>
        @endif
        <div class="cart-summary-item">
            Total <span class="float-right">EGP {{$cartTotal}}</span>
        </div>
    </div>

    <div class="cart-payment-container">
        <form method="POST" action="{{ url('/buy-tickets') }}">
        @csrf
        
        <div class="form-check" style="display: none;">
            <input
                class="form-check-input"
                type="radio"
                id="paymet_method_card"
                name="paymet_method"
                value="card"
                checked
            />
            <label class="form-check-label" for="paymet_method_card"
                >Credit Card</label
            >
        </div>

        <div class="row col-lg-12" @if($cartTotal == 0 && !$cartItems) style="display: none;" @endif>
            <input type="submit" class="btn btn-dark text-light" @if($cartTotal == 0) value="Confirm Order" @else value="Online Payment" @endif onClick="this.form.submit(); this.disabled=true; this.value='Submitting…'; ">           
        </div>
        </form>
    </div>
</section>

<!-- End Content -->
@endsection
