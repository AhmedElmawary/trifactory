@extends('layouts.app', ['body_class' => 'home-view']) @section('title', 'Home')
@section('content')
<!-- Start Content -->
<section
    class="hero-section d-flex justify-content-center no-padding"
>
    <div
        class="hero-content d-flex justify-content-center align-items-center flex-column"
    >
        <div class="hero-content-container">
            <h1>The TriFactory</h1>
            <h3>THE HOME OF ENDURANCE SPORTS IN EGYPT</h3>
            <a href="/events" class="btn btn-dark">Explore Events</a>
        </div>
    <div class="hero-content-bg"></div>
    </div>
    <img src="/images/home.jpg" alt="Hero Image" class="hero-image" />
</section>

<section
    class="events-section container @if($upcomingEvents->count() === 0) vouchers-section @endif"
>
    <h3 class="section-title">
        <img
            src="images/events-icon.svg"
            alt="events-icon"
            class="icon"
        />Upcoming Events
    </h3>

    @foreach($upcomingEvents->chunk(2) as $events)
    <div class="row">
        @foreach($events as $event)
        <div class="col-lg-6 event-card" style="padding-top: 5%">
            @if($event->eventimages()->cover()->first())
            <img
                src="/storage/{{ $event->eventimages()->cover()->first()->image }}"
                alt="Event Image"
            />
            @else
            <img src="/images/placeholder.svg" alt="Event Image" />
            @endif
            <a href="event-details/{{$event->id}}">
                <div
                    class="d-flex justify-content-center align-items-center flex-column event-details"
                >
                    <h5>{{$event->name}}</h5>
                    <p>
                        {{ \Carbon\Carbon::parse($event->event_start)->format('F jS Y')









                        }}, {{$event->city}}, {{$event->country}}
                    </p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @endforeach @if($upcomingEvents->count() === 0)
    <div class="row">
        <div
            class="col-lg-12 d-flex justify-content-center align-items-center flex-column voucher-box"
        >
            <h4>Stay tuned for our upcoming 2019 events</h4>
            <a href="/events" class="btn btn-dark">Previous Events</a>
        </div>
    </div>
    @endif
</section>

<section class="vouchers-section container no-height">
    <h3 class="section-title">
        <img src="images/voucher-icon.svg" alt="voucher-icon" class="icon" />Buy
        Vouchers
    </h3>

    <div class="row">
        <div
            class="col-lg-12 d-flex justify-content-center align-items-center flex-column voucher-box"
        >
            <h4>Know someone who would love to join one of our events?</h4>
            <h6>
                Now you can buy a gift voucher for your friends and family to
                use it in any of our current or upcoming events.
            </h6>
            <a href="purchase-voucher" class="btn btn-dark"
                >Purchase a Voucher</a
            >
        </div>
    </div>
</section>

<section class="results-section container no-height">
    <h3 class="section-title">
        <img
            src="images/results-icon.svg"
            alt="results-icon"
            class="icon"
        />Leaderboard
    </h3>

    <div class="row">
        <div class="col-lg-12 results-head">
            <h5>Male</h5>
        </div>

        <div class="col-lg-12 table-responsive-lg">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Name</th>
                        <th scope="col">Nationality</th>
                        <th scope="col">Age Group</th>
                        <th scope="col">Club</th>
                        <th scope="col">Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaderboardMale as $male)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$male->name}}</td>
                        <td>{{$male->country_code}}</td>
                        <td>{{$male->category}}</td>
                        <td>{{$male->club}}</td>
                        <td>{{$male->total_points}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 results-head">
            <a
                href="/leaderboard#pills-rankings-male"
                class="bbtn dark btn-clear float-right mt-2"
                >View More</a
            >
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 results-head">
            <h5>Female</h5>
        </div>

        <div class="col-lg-12 table-responsive-lg">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Name</th>
                        <th scope="col">Nationality</th>
                        <th scope="col">Age Group</th>
                        <th scope="col">Club</th>
                        <th scope="col">Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaderboardFemale as $female)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$female->name}}</td>
                        <td>{{$female->country_code}}</td>
                        <td>{{$female->category}}</td>
                        <td>{{$female->club}}</td>
                        <td>{{$female->total_points}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 results-head">
            <a
                href="/leaderboard#pills-rankings-female"
                class="bbtn dark btn-clear float-right mt-2"
                >View More</a
            >
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 results-head">
            <h5>Club</h5>
        </div>

        <div class="col-lg-12 table-responsive-lg">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Rank</th>
                        <th scope="col">Club</th>
                        <th scope="col">Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaderboardClub as $club)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$club->club}}</td>
                        <td>{{$club->total_points}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 results-head">
            <a
                href="/leaderboard#pills-rankings-club"
                class="bbtn dark btn-clear float-right mt-2"
                >View More</a
            >
        </div>
    </div>
</section>

<section class="gallery-section container no-height no-separator">
    <h3 class="section-title">
        <img
            src="images/gallery-icon.svg"
            alt="gallery-icon"
            class="icon"
        />Gallery
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="home-gallery">
                @if ($gallery) @foreach($gallery->galleryimage as $image)
                <img
                    class="gallery-image"
                    src="/storage/{{ $image->image }}"
                    alt="Gallery Image"
                />
                @endforeach @endif
            </div>
        </div>
    </div>
</section>

<!-- End Content -->
@endsection
