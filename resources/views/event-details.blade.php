@extends('layouts.app', ['body_class' => 'event-details-view'])
@section('title', $event->name)
@section('content')
<script>
  function onProceedtoCheckout() {
      fbq('track', 'InitiateCheckout');
  }
</script>
<!-- Start Content -->
<form enctype="multipart/form-data" id="add_to_cart" method="POST" action="{{ url('/cart') }}">
@csrf
<style>
  html, body {
    scroll-behavior: smooth;
  }
</style>
<section class="event-summary container">
  <div class="row">
    <div class="col-lg-6 order-lg-1">
      <div class="event-slider">
        @foreach($event->eventimages()->get() as $image)
          <img src="/storage/{{ $image->image }}">
        @endforeach
      </div>
      {{-- <div class="event-slider-nav">
        @foreach($event->eventimages()->get() as $image)
          <img src="/storage/{{ $image->image }}">
        @endforeach
      </div> --}}
    </div>
    <div class="col-lg-6">
      <div class="event-title mb-3">{{ $event->name }}</div>
      <div class="row mb-3">
        <div class="col-lg-7 event-sub-details">
          <img class="details-icon" src="/images/calendar-icon.svg">
          <span class="details-text">@if($coming_soon) @if (isset($event->event_start)) {{ \Carbon\Carbon::parse($event->event_start)->format('F')}} @else Coming Soon @endif @else {{ \Carbon\Carbon::parse($event->event_start)->format('F jS Y')}}{{ ($event->event_start != $event->event_end) ? '-'. \Carbon\Carbon::parse($event->event_end)->format('F jS Y') : ''}}@endif</span>
        </div>
        <div class="col-lg-5 event-sub-details">
          <img class="details-icon" src="/images/location-icon.svg">
          <span class="details-text">@if($coming_soon && (!isset($event->city) || !isset($event->country))) Coming Soon @else{{$event->city}}, {{$event->country}}@endif</span>
        </div>
        
      </div>
      <div class="row mb-5">
        <div class="col-lg-12">

          <div class="custom-dropdown">
            <span class="dropdown-trigger" data-toggle="collapse" data-target="#general_info">
              General info
            </span>
            <div class="dropdown-content collapse" id="general_info" style="overflow-wrap: break-word;">
              {!! $event->details !!}
            </div>
          </div>

          <div class="custom-dropdown">
            <span class="dropdown-trigger" data-toggle="collapse" data-target="#available_races">
              @if(preg_match("/mudder/i", $event->name))
              Available Distances
              @else
              Available Races
              @endif
            </span>
            <div class="dropdown-content collapse" id="available_races">
              <ul class="mb-0">
                @foreach($event->race()->get() as $race)
                  <li>{{$race->name}}</li>
                @endforeach
              </ul>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        @if($coming_soon)
        <div class="col-lg-12"><img src="/images/coming_soon.png" alt="Coming-soon"></div>
        @else
        @if(($pastEvent || $closed) && !(isset($user) && ($user->id == 469 || $user->id == 465 || $user->id == 1468)))
        <div class="col-lg-12">Registration Closed</div>
        @else
        <div class="col-lg-2 tickets-quantity" hidden>
          <div class="custom-number">
            <input name="number_of_tickets" type="number" class="form-control form-number" value="1" min="1" max="10">
          </div>
        </div>
        <div class="col-lg-10">
          @auth
          <button id="fill_ticket_details" type="button" class="btn btn-dark dropdown-button-icon" data-toggle="collapse" data-target="#tickets_info"
              aria-expanded="false" onclick="ticket_details()">Fill Tickets Details</button>
          @endauth
          @guest
          <button class="btn btn-dark" id="open_login_modal">Fill Tickets Details</button>
          @endguest
        </div>
        @endif
        @endif
      </div>
      @if(preg_match("/mudder/i", $event->name))
      <br>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <div class="row">
          <div class="alert alert-light" role="alert">
              <div>
                <i class="fas fa-exclamation-triangle"></i>
                <strong> Important Notes: </strong><br> <ul><li>Participants taking on Tough Mudder Egypt together should select the same date and same team name when registering. Final timeslots for all participants and teams will be determined following the General Registration Deadline on November 30th, 2019. </li></ul>
                <ul><li>Participants under 16 years old and participating in Tough Mudder 5K must be accompanied by a parent/guardian at all times.</li></ul>
              </div>
          </div>
      </div>
      @endif
    </div>
  </div>
</section>

<div class="collapse" id="tickets_info">
  <section class="container no-height no-separator no-padding sub-title-section">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-sub-title ">
          <h3>Fill Ticket(s) Details</h3>
          <p>{{ \Carbon\Carbon::parse($event->event_start)->format('F jS Y')}}, {{$event->city}}, {{$event->country}}</p>
        </div>

      </div>
    </div>
  </section>
  <section class="container no-height ticket-info-section" id="ticket_info_1">
    <div class="row">
      <div class="col-lg-12">
        <span class="ticket-no">Ticket 1</span>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="ticket_1_use_someone" name="ticket_1_use" value="someone">
          <label class="form-check-label" for="ticket_1_use_someone">Buying for someone</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="ticket_1_use_myself" name="ticket_1_use" value="myself"
            checked>
          <label class="form-check-label" for="ticket_1_use_myself">Buying for myself</label>
        </div>
      </div>
      <div class="col-lg-6 mt-3" own-ticket-hide>
        <div class="input-group">
          <input type="text" required class="form-control " placeholder="First Name" name="ticket_1_firstname" value="@auth{{ $user->firstname }}@endauth" />
        </div>

      </div>
      <div class="col-lg-6 mt-3" own-ticket-hide>
        <div class="input-group">
          <input type="text" required class="form-control " placeholder="Last Name" name="ticket_1_lastname" value="@auth{{ $user->lastname }}@endauth" />
        </div>

      </div>
      <div class="col-lg-6 mt-3" own-ticket-hide>
        <div class="input-group">
          <input type="text" minlength="11" maxlength="11" required class="form-control " placeholder="Phone" name="ticket_1_phone" value="@auth{{ $user->phone }}@endauth" />
        </div>
      </div>
      <div class="col-lg-6 mt-3" own-ticket-hide>
        <div class="input-group">
          <input type="email" required class="form-control " placeholder="E-mail" name="ticket_1_email" value="@auth{{ $user->email }}@endauth" />
        </div>

      </div>
      
      <div class="col-lg-6 mt-3">
        <div class="input-group">
          <select class="custom-select ticket_race" name="ticket_1_race" required>
            <option disabled value="" selected>Race</option>

            @foreach($event->race()->get() as $race)
              <option value="{{$race->id}}">{{$race->name}}</option>
            @endforeach

          </select>
        </div>

      </div>
      <div class="col-lg-6 mt-3">
        <div class="input-group">
          <select class="custom-select ticket_type" name="ticket_1_type" required>
            <option disabled value="" selected>Ticket Type</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row meta">
        <!-- meta data placeholder -->
    </div>
  </section>
  @if ($event->id == 7)
    <div class="container no-height no-separator" style="font-size: 12px;font-weight: 400;">
      **Photographs of valid national identification cards or passports are necessary to ensure your safety & security, and to make sure that only participants are granted access to the event venue.
    </div><br>
    @endif
  <section class="container no-height no-separator">
      <div class="row">
      <div class="col-lg-12 text-right">
        @auth
        <input type="submit" class="btn btn-dark" id="open_added_to_cart_modal" value="Add Ticket(s) to Cart">
        @endauth
        @guest
        <button class="btn btn-dark" id="open_login_modal">Add Ticket(s) to Cart</button>
        @endguest
      </div>
    </div>
  </section>
</div>
<!-- Added to Cart Modal -->
<div class="modal fade custom-modal" id="added_to_cart_modal" tabindex="-1" role="dialog"
  aria-labelledby="phone_verify_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="header">
        <!-- <h3 class="modal-title">Verification code sent to this number:</h3> -->
        <img src="/images/success-icon.svg" class="modal-icon">
        <span class="modal-sub-title">Ticket(s) added to your Cart for {{ $event->name }}</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <img src="/images/close-icon.svg" alt="close icon">
        </button>
      </div>
      <div class="content">
        <p class="modal-text"></p>
        <a onclick="onProceedtoCheckout()" href="/cart" class="btn btn-dark light">Proceed to Checkout</a>
        <a href="/events" class="btn btn-clear text-dark">Explore More Events</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-modal" id="login_modal" tabindex="-1" role="dialog"
aria-labelledby="phone_verify_modal" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="header">
      <!-- <h3 class="modal-title">Verification code sent to this number:</h3> -->
      <img src="/images/success-icon.svg" class="modal-icon">
      <span class="modal-sub-title">Login or Sign up</span>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="/images/close-icon.svg" alt="close icon">
      </button>
    </div>
    <div class="content">
      <p class="modal-text">Please login or create an account to add items to your cart.</p>
      <a href="/login" class="btn btn-dark light">Proceed to Login</a>
      <a href="/register" class="btn btn-clear text-dark">Proceed to Sign up</a>
    </div>
  </div>
</div>
</div>
</form>
<!-- End Content -->
@endsection