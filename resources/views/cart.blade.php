@extends('layouts.app', ['body_class' => 'cart-view'])
@section('title', 'Cart')
@section('content')
<script>
  function onProceedtoPayment() {
      fbq('track', 'InitiateCheckout');
  }
</script>
<!-- Start Content -->
<section class="container no-height no-separator">
  <h3 class="section-title">
    <img src="/images/tickets-icon.svg" alt="tickets-icon" class="icon">Bookings Summary
  </h3>

  <div class="row booking-summary-container">
    <!-- <div class="col-lg-12">
      <div class="section-sub-title small">
        <h3>Event 1</h3>
        <p>June 19th 2018, Aswan, Egypt</p>
      </div>
    </div> -->
    
    @foreach($cartItems as $itemKey => $item)
    <div class="col-lg-12 summary-ticket">
      <span class="ticket-no mb-2 mt-3">Ticket {{$loop->iteration}}</span>
      <span style="float:right;">
        <form method="POST" action="{{ url('/cart/remove') }}">
        @csrf
        <input name="item_key" type="hidden" value="{{$itemKey}}" />
        <input type="image" src="/images/close-icon.svg" alt="Submit" width="50%" />
        </form>
      </span>
      <div class="row">
        @foreach($item['attributes'] as $key => $val)
          @if(strpos($key, '_') === false)
            <div class="col-lg-4 mb-2 ticket-data">
              {{$key}}: <b>{{$val}}</b>
            </div>
          @endif
        @endforeach
      </div>
      <div class="row" style="margin-top:20px;margin-bottom:20px;">
          <div class="row col-lg-6">
            <form class="code-form" method="POST" action="{{ url('/cart/item/code') }}">
              @csrf
              <div class="input-group">
                  @csrf
                <input name="item" type="hidden" value="{{ $item['id'] }}" />
                <input
                    id="code"
                    name="code"
                    value="@if(count($item['conditions'])) {{ $item['conditions'][0]->getAttributes()['code'] }} @endif"
                    type="text"
                    class="form-control dark-bg"
                    placeholder="Promocode"
                    style="margin-right:20px"
                    @if($item['conditions']) disabled @endif
                />
                <button @if(count($item['conditions'])) disabled @endif type="submit" class="btn btn-dark text-light" id="use_code_{{ $key }}">
                    Use Promocode
                </button>
                <span id="undo_code_button" class="@if(count($item['conditions'])) active @endif" >
                    Using promocode "@if(count($item['conditions'])) {{ $item['conditions'][0]->getAttributes()['code'] }} @endif". Your item
                    price is @if(count($item['conditions'])) now @endif EGP @if(count($item['conditions'])) {{$item['attributes']['Price'] - $item['conditions'][0]->parsedRawValue }} @endif
                    <br />
                    <a class="undo-code" href="#">Undo</a>
                </span>
                 @if($errors->$itemKey)
                  @if ($errors->$itemKey->has('code'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->$itemKey->first('code') }}</strong>
                      </span>
                    @endif
                  @endif
              </div>
            </form>
          </div>
      </div>
      
    </div>
    @endforeach

  </div>
  <div class="row cart-title">
    <h3>Cart Total</h3>
  </div>
  <div class="row cart-summary-container col-lg-6">
    <div class="cart-summary-item separator">
      Cart total <span class="float-right">EGP {{$cartSubTotal}}</span>
    </div>
    <div class="cart-summary-item">
      Total <span class="float-right">EGP {{$cartTotal}}</span>
    </div>
    <form @if ($cartTotal == 0) method="POST" action="{{ url('/buy-tickets') }}" @else method="GET" action="/cart/payment"  @endif>
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
    @if (count($cartItems) > 0)
    <input type="submit" onclick="onProceedtoPayment()" class="btn btn-dark text-light mt-4 mb-4" value="{{($cartTotal == 0) ? "Confirm Order" : "Proceed to Payment"}}">
    @endif
    </form>
  </div>
</section>

<!-- End Content -->
@endsection