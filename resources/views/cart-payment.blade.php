@extends('layouts.app', ['body_class' => 'cart-payment-view'])
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
            You can redeem your credits that you have in your balance to buy
            tickets. If your credits are not enough to buy a full ticket, you
            will pay the remaining cost in cash or credit.
        </p>
        <h4 class="mt-3">You have {{$credit}} credits (EGP {{$credit}}) in your wallet</h4>
        <form id="credit-form" method="POST" action="/cart/credit">
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
        <h3>Add Voucher Code</h3>
    </div>
    <div class="cart-voucher-container col-lg-12">
        <p>You can use voucher codes to get discounts on tickets.</p>
        <div class="row col-lg-6">
            <div class="input-group">
                <input
                    type="text"
                    class="form-control dark-bg"
                    placeholder="Type the Code"
                />
            </div>
        </div>
        <div class="row col-lg-12">
            <button class="btn btn-dark text-light">Use Voucher Code</button>
        </div>
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
            {{$item['attributes']['Ticket Type']}} <span class="float-right">EGP {{$item['attributes']['Price']}}</span>
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
        <div class="cart-summary-item">
            Total <span class="float-right">EGP {{$cartTotal}}</span>
        </div>
    </div>

    <div class="cart-payment-container">
        <div class="form-check mb-2">
            <input
                class="form-check-input"
                type="radio"
                id="paymet_method_cash"
                name="paymet_method"
                value="cash"
            />
            <label class="form-check-label" for="paymet_method_cash"
                >Cash</label
            >
        </div>
        <div class="form-check">
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

        <div class="row col-lg-12">
            <button class="btn btn-dark text-light">Place Order</button>
        </div>
    </div>
</section>

<!-- End Content -->
@endsection
