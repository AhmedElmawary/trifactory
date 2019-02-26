@extends('layouts.app', ['body_class' => 'cart-view'])
@section('content')
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
    @foreach($cartItems as $key => $item)
    <div class="col-lg-12 summary-ticket">
      <span class="ticket-no mb-2 mt-3">Ticket {{$loop->iteration}}</span>
      <span style="float:right;">
        <form method="POST" action="{{ url('/cart/remove') }}">
        @csrf
        <input name="item_key" type="hidden" value="{{$key}}" />
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
    @if (count($cartItems) > 0)
    <a  href="/cart/payment" class="btn btn-dark text-light mt-4 mb-4">Proceed to Payment</a>
    @endif
  </div>
</section>

<!-- End Content -->
@endsection