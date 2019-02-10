@extends('layouts.app', ['body_class' => 'home-view'])
@section('content')
    <!-- Start Content -->
    <section class="hero-section d-flex justify-content-center no-separator no-padding">
  <div class="hero-content d-flex justify-content-center align-items-center flex-column">
    <div class="hero-content-container">
      <h1>The Trifactory</h1>
      <h3>THE HOME OF ENDURANCE SPORTS IN EGYPT</h3>
      <a href="/events" class="btn btn-dark">Explore Events</a>
    </div>
    <div class="hero-content-bg"></div>
  </div>
  <img src="images/placeholder-dark.svg" alt="Hero Image" class="hero-image">
</section>

<section class="events-section container">
  <h3 class="section-title">
  <img src="images/events-icon.svg" alt="events-icon" class="icon">Upcoming Events
</h3>

  
@foreach($upcomingEvents->chunk(2) as $events)
    <div class="row">
        @foreach($events as $event)
        <div class="col-lg-6 event-card">
        <img src="images/placeholder.svg" alt="Event Image">
        <a href="event-details.html">
          <div class="d-flex justify-content-center align-items-center flex-column event-details">
            <h5>{{$event->name}}</h5>
            <p>{{ \Carbon\Carbon::parse($event->event_start)->format('F jS Y')}}, {{$event->city}}, {{$event->country}}</p>
          </div>
        </a>
      </div>
        @endforeach
    </div>
@endforeach
  
</section>

<section class="vouchers-section container no-height">
  <h3 class="section-title">
  <img src="images/voucher-icon.svg" alt="voucher-icon" class="icon">Buy Vouchers
</h3>

  <div class="row">
    <div class="col-lg-12 d-flex justify-content-center align-items-center flex-column voucher-box">
      <h4>Know someone who would love to join one of our events?</h4>
      <h6>Now you can buy a gift voucher for your friends and family to use it in any of our current or upcoming events.</h6>
      <a href="purchase-voucher" class="btn btn-dark">Purchase a Voucher</a>
    </div>
  </div>
</section>

<section class="gallery-section container no-height no-separator">
  <h3 class="section-title">
  <img src="images/gallery-icon.svg" alt="gallery-icon" class="icon">Gallery
</h3>

  <div class="row">
    <div class="col-lg-12">
      <div class="home-gallery">
        
        <img class="gallery-image" src="images/placeholder.svg" alt="Gallery Image">
        
        <img class="gallery-image" src="images/placeholder.svg" alt="Gallery Image">
        
        <img class="gallery-image" src="images/placeholder.svg" alt="Gallery Image">
        
      </div>
    </div>
  </div>
</section>

    <!-- End Content -->
    @endsection