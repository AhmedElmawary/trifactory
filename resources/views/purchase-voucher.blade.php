@extends('layouts.app', ['body_class' => 'purchase-voucher-view'])
@section('content')
<!-- Start Content -->
<form method="POST" action="/buy-vouchers">
  @csrf
<section class="container no-height">
  <h3 class="section-title">
    <img src="images/voucher-icon.svg" alt="voucher-icon" class="icon">Buy Vouchers
  </h3>

  <div class="row">
    <div class="col-lg-6">
      <label class="input-label">Enter recipient e-mail</label>
      <div class="input-group">
        <input name="recipient_email" type="text" class="form-control " placeholder="E-mail">
      </div>
    </div>

    <div class="col-lg-6">
      <label class="input-label"></label>
      <h6>Purchase a voucher for your friends and family were they can use it to register and pay for any of our current or upcoming events.</h6>
    </div>
  </div>

  <div class="row">
      <div class="col-lg-6">
        <label class="input-label">Enter recipient name</label>
        <div class="input-group">
          <input name="recipient_name" type="text" class="form-control " placeholder="Name">
        </div>
      </div>

      <div class="col-lg-6">
      <!-- <label class="input-label"></label> -->
      <h6>Terms of use: </h6>
      <h6>This voucher can be used for one time only when registering in our races. In the case the amount of the voucher was not consumed fully, the full voucher amount, the rest of the amount not used will remain in the credit balance to be used in any upcoming races.</h6>
    </div>
  </div>

  <div class="row">
      <div class="col-lg-6">
        <label class="input-label">Message</label>
        <div class="input-group">
          <textarea name="message" class="form-control" placeholder="Message"></textarea>
        </div>
      </div>
  </div>

</section>

<section class="container no-height">
  <div class="row">
    <div class="col-lg-5">
      <label class="input-label">Credit amount</label>

      <div class="input-group">

        <div class="form-check custom-radio-input">
          <label class="form-check-label">
            <input class="form-check-input" name="discount_amount" type="radio" value="100" checked>
            <span class="label-cotent">100</span>
          </label>
        </div>

        <div class="form-check custom-radio-input">
          <label class="form-check-label">
            <input class="form-check-input" name="discount_amount" type="radio" value="250">
            <span class="label-cotent">250</span>
          </label>
        </div>

        <div class="form-check custom-radio-input">
          <label class="form-check-label">
            <input class="form-check-input" name="discount_amount" type="radio" value="300">
            <span class="label-cotent">300</span>
          </label>
        </div>

      </div>

    </div>
    <div class="col-lg-3">
      <label class="input-label">Number of vouchers</label>

      <div class="custom-number">
        <input name="qty" type="number" class="form-control form-number" value="1" min="1" max="10">
      </div>

    </div>
  </div>
</section>

<section class="container no-height no-separator">
  <div class="row">
    <div class="col-lg-12 text-right">
      <button type="submit" class="btn btn-dark">Quick Checkout</button>
      <br>
      <!-- <button class="btn btn-clear"><i class="fas fa-shopping-cart mr-3"></i>Add to cart</button> -->
    </div>
  </div>
</section>
</form>
<!-- End Content -->
@endsection