@extends('layouts.app', ['body_class' => 'profile-view']) @section('title',
'Leaderboard') @section('content')
<!-- Start Content -->
<section class="main-profile-section container no-height no-separator">
    <div class="row">
            <div class="col-lg-12 profile-content-container text-center">
                <img width="100%" height="80%" src="/images/endurance_league_banner.jpg" alt="endurance-league-icon">
                <a
                class="nav-link "
                style="display:inline;cursor:pointer;color: red; text-decoration: underline"
                onclick="showEnduranceLeagueModal()">
                Click here for more info
                </a>
            </div>
    </div>
    <div class="row">
        <div class="col-lg-12 profile-content-container">
            <ul class="nav nav-pills profile-nav" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="pills-rankings-male-tab"
                        data-toggle="pill"
                        href="#pills-rankings-male"
                        role="tab"
                        aria-controls="pills-rankings-male"
                        aria-selected="true"
                        >Male</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="pills-rankings-female-tab"
                        data-toggle="pill"
                        href="#pills-rankings-female"
                        role="tab"
                        aria-controls="pills-rankings-female"
                        aria-selected="false"
                        >Female</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="pills-rankings-club-tab"
                        data-toggle="pill"
                        href="#pills-rankings-club"
                        role="tab"
                        aria-controls="pills-rankings-club"
                        aria-selected="false"
                        >Club</a
                    >
                </li>
                <li class="nav-item"></li>
                <li class="nav-item">
                    <h5>Filter</h5>
                    <input type="text" placeholder="Name.." name="name" id="name_filter" autofocus>
                    <input type="text" placeholder="Age Group.." name="category" id="category_filter">
                    <input type="text" placeholder="Gender Position.." name="gender_position" id="gender_position_search">
                    <button id=filter_button type="submit" onclick="filter()" ><i class="fa fa-search"></i></button>
                </li>
            </ul>
            <div
                class="tab-content male-rnakings-tab-content"
                id="pills-tabContent"
            >
                <!-- Personal Information -->
                <div
                    class="tab-pane show active"
                    id="pills-rankings-male"
                    role="tabpanel"
                    aria-labelledby="pills-rankings-male-tab"
                >
                    <div class="row">
                        <div class="col-lg-12 table-responsive-lg">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Rank</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Nationality</th>
                                        <th scope="col">Age Group</th>
                                        <th scope="col">Gender Position</th>
                                        <th scope="col">Club</th>
                                        <th scope="col">Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaderboardMale as $male)
                                    <tr>
                                        <td>{{ ($leaderboardMale ->currentpage()-1) * $leaderboardMale ->perpage() + $loop->index + 1 }}</td>
                                        <td>{{$male->name}}</td>
                                        <td>{{$male->country_code}}</td>
                                        <td>{{$male->category}}</td>
                                        <td>{{$male->gender_position}}</td>
                                        <td>{{$male->club}}</td>
                                        <td>{{$male->total_points}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            Showing {{$leaderboardMale->count()}} from {{$leaderboardMale->total()}} users
                        </div>
                        <div class="col-sm-4">
                            <span >{{ $leaderboardMale->fragment('pills-rankings-male')->links() }}</span>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                </div>
                <div
                    class="tab-pane"
                    id="pills-rankings-female"
                    role="tabpanel"
                    aria-labelledby="pills-rnakings-female-tab"
                >
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Rank</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Nationality</th>
                                        <th scope="col">Age Group</th>
                                        <th scope="col">Gender Position</th>
                                        <th scope="col">Club</th>
                                        <th scope="col">Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($leaderboardFemale as $female)
                                    <tr>
                                        <td>
                                            {{(($leaderboardFemale->currentPage() -1) * 25) + $loop->iteration}}
                                        </td>
                                        <td>{{$female->name}}</td>
                                        <td>{{$female->country_code}}</td>
                                        <td>{{$female->category}}</td>
                                        <td>{{$female->gender_position}}</td>
                                        <td>{{$female->club}}</td>
                                        <td>{{$female->total_points}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-sm-4">
                                Showing {{$leaderboardFemale->count()}} from {{$leaderboardFemale->total()}} users
                            </div>
                            <div class="col-sm-4">
                                <span >{{ $leaderboardFemale->fragment('pills-rankings-female')->links() }}</span>
                            </div>
                            <div class="col-sm-4"></div>
                    </div>
                </div>
                <div
                    class="tab-pane"
                    id="pills-rankings-club"
                    role="tabpanel"
                    aria-labelledby="pills-rnakings-club-tab"
                >
                    <div class="row">
                        <div class="col-lg-12">
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
                                    @if (stripos($club->club, 'independent') == false)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$club->club}}</td>
                                        <td>{{$club->total_points}}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-sm-4">
                                Showing {{$leaderboardClub->count()}} from {{$leaderboardClub->total()}} users
                            </div>
                            <div class="col-sm-4">
                                <span >{{ $leaderboardClub->fragment('pills-rankings-club')->links() }}</span>
                            </div>
                            <div class="col-sm-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <div class="modal fade custom-modal" id="endurance_league_details_modal" tabindex="-1" role="dialog"
            aria-labelledby="phone_verify_modal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="header">
                <!-- <h3 class="modal-title">Verification code sent to this number:</h3> -->
                {{-- <img src="/images/success-icon.svg" class="modal-icon"> --}}
                {{-- <span class="modal-sub-title">Endurance League Details</span> --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="/images/close-icon.svg" alt="close icon">
                </button>
                </div>
                <div class="content">
                <img width="100%" src="/images/endurance_league_details.jpg" alt="endurance-league-details">
                </div>
                <br>
            </div>
            </div>
        </div>
<script>
    var input = document.getElementById("name_filter");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("filter_button").click();
        }
    });
    var input = document.getElementById("category_filter");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("filter_button").click();
        }
    });
    var input = document.getElementById("gender_position_search");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
        event.preventDefault();
        document.getElementById("filter_button").click();
        }
    });
</script>
<!-- End Content -->
@endsection
