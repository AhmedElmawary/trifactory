@extends('layouts.app', ['body_class' => 'events-view'])
@section('content')
    <!-- Start Content -->
    <section class="hero-section d-flex justify-content-center align-items-center no-separator no-padding">
  <div class="hero-content d-flex justify-content-center align-items-center flex-column">
    <h1>Events</h1>
  </div>
  <img src="/images/events.jpg" alt="Hero Image" class="hero-image">
</section>

<section class="events-section container no-separator">
  <div class="row event-cards-container">
    
      <div class="col-lg-12 event-card">
  <img class="event-cover" src="images/placeholder-dark.svg" alt="Event Cover">
  <a href="event-details.html">
    <div class="d-flex justify-content-center align-items-center flex-column event-details left">
      <img src="images/placeholder.svg" alt="Event Thumb" class="event-thumb">
    </div>
    <div class="d-flex justify-content-center align-items-center flex-column event-details right">
      <h5>Event 1</h5>
      <p>August 15th 2018, Aswan, Egypt</p>
    </div>
  </a>
</div>

    
      <div class="col-lg-12 event-card">
  <img class="event-cover" src="images/placeholder-dark.svg" alt="Event Cover">
  <a href="event-details.html">
    <div class="d-flex justify-content-center align-items-center flex-column event-details left">
      <img src="images/placeholder.svg" alt="Event Thumb" class="event-thumb">
    </div>
    <div class="d-flex justify-content-center align-items-center flex-column event-details right">
      <h5>Event 2</h5>
      <p>August 19th 2018, Sahl Hasheesh, Egypt</p>
    </div>
  </a>
</div>

    
      <div class="col-lg-12 event-card">
  <img class="event-cover" src="images/placeholder-dark.svg" alt="Event Cover">
  <a href="event-details.html">
    <div class="d-flex justify-content-center align-items-center flex-column event-details left">
      <img src="images/placeholder.svg" alt="Event Thumb" class="event-thumb">
    </div>
    <div class="d-flex justify-content-center align-items-center flex-column event-details right">
      <h5>Event 3</h5>
      <p>August 25th 2018, Cairo, Egypt</p>
    </div>
  </a>
</div>

    
      <div class="col-lg-12 event-card">
  <img class="event-cover" src="images/placeholder-dark.svg" alt="Event Cover">
  <a href="event-details.html">
    <div class="d-flex justify-content-center align-items-center flex-column event-details left">
      <img src="images/placeholder.svg" alt="Event Thumb" class="event-thumb">
    </div>
    <div class="d-flex justify-content-center align-items-center flex-column event-details right">
      <h5>Event 4</h5>
      <p>August 30th 2018, Aswan, Egypt</p>
    </div>
  </a>
</div>

    
  </div>
</section>

    <!-- End Content -->
    @endsection