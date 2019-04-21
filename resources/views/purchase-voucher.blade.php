@extends('layouts.app', ['body_class' => 'purchase-voucher-view'])
@section('title', 'Purchase Voucher') @section('content')
<!-- Start Content -->
<form method="POST" action="{{ url('/buy-vouchers') }}">
    @csrf
    <section class="container no-height">
        <h3 class="section-title">
            <img
                src="images/voucher-icon.svg"
                alt="voucher-icon"
                class="icon"
            />Buy Vouchers
        </h3>

        <div class="row">
          <div class="col-12 d-sm-block d-lg-none">
              <label class="input-label"></label>
              <h6>
                  Purchase a voucher for your friends and family were they can
                  use it to register and pay for any of our current or
                  upcoming events.
              </h6>
          </div>
      </div>
      <div class="row">
        <div class="col-lg-6 d-sm-block d-lg-none"">
          <h6>Terms of use:</h6>
          <h6>
              This voucher can be used for one time only when registering
              in our races. In the case the amount of the voucher was not
              consumed fully, the full voucher amount, the rest of the
              amount not used will remain in the credit balance to be used
              in any upcoming races.
          </h6>
        </div>
      </div>

        <div class="row">
            <div class="col-lg-6 col-12">
                <label class="input-label">Enter recipient e-mail</label>
                <div class="input-group">
                    <input
                        required
                        name="recipient_email"
                        type="email"
                        class="form-control "
                        placeholder="E-mail"
                    />
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block">
                <label class="input-label"></label>
                <h6>
                    Purchase a voucher for your friends and family were they can
                    use it to register and pay for any of our current or
                    upcoming events.
                </h6>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-12">
                <label class="input-label">Enter recipient name</label>
                <div class="input-group">
                    <input
                        required
                        name="recipient_name"
                        type="text"
                        class="form-control "
                        placeholder="Name"
                    />
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block"">
                <h6>Terms of use:</h6>
                <h6>
                    This voucher can be used for one time only when registering
                    in our races. In the case the amount of the voucher was not
                    consumed fully, the full voucher amount, the rest of the
                    amount not used will remain in the credit balance to be used
                    in any upcoming races.
                </h6>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-12">
                <label class="input-label">Enter recipient phone</label>
                <div class="input-group">
                    <input
                        required
                        name="recipient_phone"
                        type="text"
                        class="form-control "
                        placeholder="Phone"
                    />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-12">
                <label class="input-label">Message</label>
                <div class="input-group">
                    <textarea
                        required
                        name="message"
                        class="form-control"
                        placeholder="Message"
                    ></textarea>
                </div>
            </div>
        </div>
    </section>

    <section class="container no-height">
        <div class="row">
            <div class="col-lg-12 col-12">
                <label class="input-label">Credit amount</label>

                <div class="input-group">
                    <div class="form-check custom-radio-input">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                name="discount_amount"
                                type="radio"
                                value="100"
                                checked
                            />
                            <span class="label-cotent">100</span>
                        </label>
                    </div>

                    <div class="form-check custom-radio-input">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                name="discount_amount"
                                type="radio"
                                value="250"
                            />
                            <span class="label-cotent">250</span>
                        </label>
                    </div>

                    <div class="form-check custom-radio-input">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                name="discount_amount"
                                type="radio"
                                value="300"
                            />
                            <span class="label-cotent">300</span>
                        </label>
                    </div>

                    <div class="form-check custom-radio-input">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                name="discount_amount"
                                type="radio"
                                value="300"
                            />
                            <span class="label-cotent">500</span>
                        </label>
                    </div>

                    <div class="form-check custom-radio-input">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                name="discount_amount"
                                type="radio"
                                value="300"
                            />
                            <span class="label-cotent">800</span>
                        </label>
                    </div>

                    <div class="form-check custom-radio-input">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                name="discount_amount"
                                type="radio"
                                value="300"
                            />
                            <span class="label-cotent">1000</span>
                        </label>
                    </div>

                    <div class="form-check custom-radio-input">
                        <label class="form-check-label">
                            <input
                                class="form-check-input"
                                name="discount_amount"
                                type="radio"
                                value="300"
                            />
                            <span class="label-cotent">1500</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-3" style="display:none;">
                <label class="input-label">Number of vouchers</label>

                <div class="custom-number">
                    <input
                        name="qty"
                        type="number"
                        class="form-control form-number"
                        value="1"
                        min="1"
                        max="10"
                    />
                </div>
            </div>
        </div>

        <div class="cart-payment-container" style="display:none;">
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
        </div>
    </section>

    <section class="container no-height no-separator">
        <div class="row">
            <div class="col-lg-12 col-12 text-right">
                @auth
                <button class="btn btn-dark" type="submit">
                    Quick Checkout
                </button>
                @endauth @guest
                <button class="btn btn-dark" id="open_login_modal">
                    Quick Checkout
                </button>
                @endguest
                <br />
                <!-- <button class="btn btn-clear"><i class="fas fa-shopping-cart mr-3"></i>Add to cart</button> -->
            </div>
        </div>
    </section>
</form>
<!-- End Content -->

<div
    class="modal fade custom-modal"
    id="login_modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="phone_verify_modal"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="header">
                <!-- <h3 class="modal-title">Verification code sent to this number:</h3> -->
                <img src="/images/success-icon.svg" class="modal-icon" />
                <span class="modal-sub-title">Login or Sign up</span>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <img src="/images/close-icon.svg" alt="close icon" />
                </button>
            </div>
            <div class="content">
                <p class="modal-text">
                    Please login or create an account to add items to your cart.
                </p>
                <a href="/login" class="btn btn-dark light">Proceed to Login</a>
                <a href="/register" class="btn btn-clear text-dark"
                    >Proceed to Sign up</a
                >
            </div>
        </div>
    </div>
</div>
@endsection
