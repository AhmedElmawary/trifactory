@extends('layouts.app', ['body_class' => 'profile-view']) @section('title',
'Leaderboard') @section('content')
<!-- Start Content -->
<section class="main-profile-section container no-height no-separator">
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

<!-- End Content -->
@endsection
