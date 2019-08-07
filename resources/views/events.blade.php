@extends('layouts.app', ['body_class' => 'events-view'])
@section('title', 'Events')
@section('content')
<!-- Start Content -->
<section class="hero-section d-flex justify-content-center align-items-center no-separator no-padding">
  <div class="hero-content d-flex justify-content-center align-items-center flex-column">
    <h1>Events</h1>
  </div>
  <img src="/images/events.jpg" alt="Hero Image" class="hero-image">
</section>

<section
    class="events-section container no-separator"
>
<h3 class="section-title">
  <img src="images/events-icon.svg" alt="events-icon" class="icon">Upcoming Events
</h3>
  <div class="row event-cards-container">

    @foreach($upcoming_events as $event)
    <div class="col-lg-12 event-card">
      @if($event->eventimages()->cover()->first())
        <img class="event-cover" src="/storage/{{ $event->eventimages()->cover()->first()->image }}" alt="Event Cover">
      @else
        <img class="event-cover" src="/images/placeholder-dark.svg" alt="Event Cover">
      @endif
      <a href="/event-details/{{$event->id}}">
        <div class="d-flex justify-content-center align-items-center flex-column event-details left">
          @if($event->eventimages()->thumbnail()->first())
            <img src="/storage/{{ $event->eventimages()->thumbnail()->first()->image }}" alt="Event Thumb" class="event-thumb">
          @else
            <img src="/images/placeholder.svg" alt="Event Thumb" class="event-thumb">
          @endif
        </div>
        <div class="d-flex justify-content-center align-items-center flex-column event-details right">
          <h5>{{$event->name}}</h5>
          <p>{{ \Carbon\Carbon::parse($event->event_start)->format('F jS Y')}}, {{$event->city}}, {{$event->country}}</p>
        </div>
      </a>
    </div>
    @endforeach

  </div>
<h3 class="section-title">
  <img src="images/events-icon.svg" alt="events-icon" class="icon">Past Events
</h3>
  <div class="row event-cards-container">

    @foreach($events as $event)
    <div class="col-lg-12 event-card">
      @if($event->eventimages()->cover()->first())
        <img class="event-cover" src="/storage/{{ $event->eventimages()->cover()->first()->image }}" alt="Event Cover">
      @else
        <img class="event-cover" src="/images/placeholder-dark.svg" alt="Event Cover">
      @endif
      <a href="/event-details/{{$event->id}}">
        <div class="d-flex justify-content-center align-items-center flex-column event-details left">
          @if($event->eventimages()->thumbnail()->first())
            <img src="/storage/{{ $event->eventimages()->thumbnail()->first()->image }}" alt="Event Thumb" class="event-thumb">
          @else
            <img src="/images/placeholder.svg" alt="Event Thumb" class="event-thumb">
          @endif
        </div>
        <div class="d-flex justify-content-center align-items-center flex-column event-details right">
          <h5>{{$event->name}}</h5>
          <p>{{ \Carbon\Carbon::parse($event->event_start)->format('F jS Y')}}, {{$event->city}}, {{$event->country}}</p>
        </div>
      </a>
    </div>
    @endforeach

  </div>
</section>

<!-- End Content -->
@endsection