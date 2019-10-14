@extends('layouts.app', ['body_class' => 'cart-view'])
@section('title', 'Cash Payment Success')
@section('content')
<script>
    window.onload = function() {
      fbq('track', 'Purchase', {value: document.getElementById('costvalue').value, currency: 'EGP'});
    }
  </script>
<input id="costvalue" type="number" value="{{$order->totalCost}}" hidden>
<!-- Start Content -->
<section class="container no-height no-separator">
  <h3 class="section-title">
    <img src="/images/tickets-icon.svg" alt="tickets-icon" class="icon">Order Successful
  </h3>

  </div>
  <div class="row cart-title">
    <h3>Order information</h3>
  </div>
  <div class="row cart-summary-container col-lg-6">
    <div class="cart-summary-item separator">
        Order ID: <span class="float-right">{{$order->id}}</span>
    </div>
    <div class="cart-summary-item separator">
        Order Reference: <span class="float-right">{{$order->paymob_order_id}}</span>
    </div>
    <div class="cart-summary-item separator">
      Order Status: <span class="float-right">Pending cash collection</span>
    </div>
    <div class="cart-summary-item">
        Order Total: <span class="float-right">EGP {{$order->totalCost}}</span>
    </div>
  </div>
</section>

<!-- End Content -->
@endsection