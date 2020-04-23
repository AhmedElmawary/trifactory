@extends('layouts.app', ['body_class' => 'profile-view']) 
@section('title', 'Profile')
@section('content')
<!-- Start Content -->
<section class="main-profile-section container no-height no-separator">
    <div class="row">
        <div class="col-lg-3 profile-summary-container">
            <img style="cursor:pointer;" id="profile-image" src="{{$profile_image}}" class="profile-img" />
            <form enctype="multipart/form-data" id="profile-image-form" method="POST" action="{{ url('/profile/image') }}">
              @csrf
              <input name="profile_image" type="file" id="profile_image" accept="image/*" style="display: none;" />
            </form>
            <h4 class="profile-name">{{$user->name}}</h4>
            <span class="profile-points"
                >{{ $credit }} Credits (EGP {{ $credit }})</span
            >
            <span class="profile-name"
                ><b>Endurance league points:</b> {{ $points }}</span
            >
            <span class="profile-name"
                ><b>Gender Rank:</b> {{ $leaderboard_gender_rank }}</span
            >
            <span class="profile-name"
                ><b>Age Group Rank:</b> {{ $leaderboard_category_rank }}</span
            >
        </div>
        <div class="col-lg-9 profile-content-container">
            <ul class="nav nav-pills profile-nav" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a
                        class="nav-link active"
                        id="pills-info-tab"
                        data-toggle="pill"
                        href="#pills-info"
                        role="tab"
                        aria-controls="pills-info"
                        aria-selected="true"
                        >Personal Information</a
                    >
                </li>
                <!-- <li class="nav-item">
                    <a
                        class="nav-link"
                        id="pills-rankings-tab"
                        data-toggle="pill"
                        href="#pills-rankings"
                        role="tab"
                        aria-controls="pills-rankings"
                        aria-selected="false"
                        >Rankings</a
                    >
                </li> -->
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="pills-upcoming-events-tab"
                        data-toggle="pill"
                        href="#pills-upcoming-events"
                        role="tab"
                        aria-controls="pills-upcoming-events"
                        aria-selected="false"
                        >Upcoming Events</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="pills-previous-events-tab"
                        data-toggle="pill"
                        href="#pills-previous-events"
                        role="tab"
                        aria-controls="pills-previous-events"
                        aria-selected="false"
                        >Previous Events</a
                    >
                </li>
                <li class="nav-item">
                    <a
                        class="nav-link"
                        id="pills-wallet-tab"
                        data-toggle="pill"
                        href="#pills-wallet"
                        role="tab"
                        aria-controls="pills-wallet"
                        aria-selected="false"
                        >My Wallet</a
                    >
                </li>
            </ul>
            <div class="tab-content profile-tab-content" id="pills-tabContent">
                <!-- Personal Information -->
                <div
                    class="tab-pane show active"
                    id="pills-info"
                    role="tabpanel"
                    aria-labelledby="pills-info-tab"
                >
                    <form method="POST" action="{{ url('/profile/update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <label class="input-label">First Name</label>

                            <div class="input-group">
                                <input
                                    name="firstname"
                                    required
                                    type="text"
                                    class="form-control "
                                    placeholder="First Name"
                                    value="{{$user->firstname}}"
                                />

                                @if ($errors->has('firstname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <label class="input-label">Last Name</label>

                            <div class="input-group">
                                <input
                                    name="lastname"
                                    required
                                    type="text"
                                    class="form-control "
                                    placeholder="Last Name"
                                    value="{{$user->lastname}}"
                                />
                                @if ($errors->has('lastname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <label class="input-label">Phone Number</label>

                            <div class="input-group">
                                <input
                                    name="phone"
                                    required
                                    type="text"
                                    class="form-control "
                                    placeholder="Phone Number"
                                    value="{{$user->phone}}"
                                    @if ($user->phone != '') disabled @endif
                                />
                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <label class="input-label">Email</label>

                            <div class="input-group" >
                                <input
                                    name="email"
                                    required
                                    type="email"
                                    class="form-control"
                                    placeholder="E-Mail"
                                    value="{{$user->email}}"
                                    @if ($user->email != '') disabled @endif
                                />
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                                <label class="input-label">Year of birth</label>
    
                                <div class="input-group">
                                        <select style="margin-top:20px;" class="custom-select" name="year_of_birth" @if ($user->year_of_birth != 0) disabled @endif required>
                                                @if ($user->year_of_birth == 0)
                                                    <option value="" disabled selected>Year of Birth</option>
                                                @else
                                                    <option value="{{$user->year_of_birth}}" selected>{{$user->year_of_birth}}</option>
                                                @endif
                                                @for ($i = 1930; $i <= date('Y')-5; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                        </select>
                                        @if ($user->year_of_birth != 0)
                                        <input type="hidden" name="year_of_birth" value="{{$user->year_of_birth}}" />
                                        @endif
                                    @if ($errors->has('year_of_birth'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('year_of_birth') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6 mb-5">
                                <label class="input-label clubs">Club</label>
    
                                <select style="margin-top:20px;" class="custom-select clubs" name="club" id="profileClub" required>
                                        @if ($user->club == '')
                                            <option value="" disabled selected>What club do you represent (if any)?</option>
                                        @else
                                            <option value="{{$user->club}}" selected>{{$user->club}}</option>
                                        @endif
                                        @foreach ($clubs as $club)
                                            @if ($club->value != $user->club)
                                            <option value="{{$club->value}}">{{$club->value}}</option>
                                            @endif
                                        @endforeach
                                </select>
                                @if ($user->club != '')
                                <input type="hidden" name="club" id="inputClub" value="{{$user->club}}" />
                                @endif
                                    @if ($errors->has('club'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('club') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            <div class="col-lg-6 mb-5">
                                <label class="input-label other_club" style='display: none'>Other club</label>
                            <div class="input-group other_club" style='display: none'>
                                    <input
                                        placeholder="Please specify..."
                                        id="other_club"
                                        type="text"
                                        class="form-control{{ $errors->has('other_club') ? ' is-invalid' : '' }}"
                                        name="other_club"
                                        value="{{$user->club}}"
                                        autofocus
                                    />
            
                                    @if ($errors->has('other_club'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('other_club') }}</strong>
                                    </span>
                                    @endif
                             </div>
                            </div>
                      
                        <div class="col-lg-12 mb-5">
                            <hr class="line-separator" />
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-dark float-right" value="Submit">
                                Save Changes
                            </button>
                        </div>
                    </div>   
                    </form>
                    <form method="POST" action="{{ url('/profile/password') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="input-label">Password Change</label>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <div class="input-group">
                                <input
                                    name="password"
                                    type="password"
                                    class="form-control"
                                    placeholder="New Password"
                                />
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <div class="input-group">
                                <input
                                    name="password_confirmation"
                                    type="password"
                                    class="form-control"
                                    placeholder="New Password Confirm"
                                />

                                @if ($errors->has('password_confirmation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 mb-5">
                            <hr class="line-separator" />
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-dark float-right">
                                Change Password
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- Rankings -->
                <!-- <div
                    class="tab-pane"
                    id="pills-rankings"
                    role="tabpanel"
                    aria-labelledby="pills-rankings-tab"
                >
                    Rankings
                </div> -->
                <!-- Upcoming Events -->
                <div
                    class="tab-pane"
                    id="pills-upcoming-events"
                    role="tabpanel"
                    aria-labelledby="pills-upcoming-events-tab"
                >
                    @if(count($upcoming_events) > 0)
                    <div class="col-lg-12 table-responsive-lg">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">For</th>
                                    <th scope="col">Event</th>
                                    <th scope="col">Race</th>
                                    <th scope="col">Date</th>
                                    {{-- <th scope="col">meta</th> --}}
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($upcoming_events as $event)
                                <tr>
                                    @if (isset($event->participant_user) && $event->participant_user->id != $user->id)
                                    <td>{{ $event->participant_user->name }}</td>
                                    @else
                                    <td>Myself</td>
                                    @endif
                                    <td scope="row">{{ $event->race->event->name }}</td>
                                    <td>{{ $event->race->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->race->event->event_start)->format('F jS Y')}}</td>
                                    {{-- <td>{{ $event }}</td> --}}
                                    <td>
                                        <a
                                            class="event-details-trigger" style="cursor: pointer" onclick="show_details({{$event->id}})"
                                            >Details @if ($event->race->event['cancel_availablility']) & Cancellation @endif</a
                                            {{-- >Details & Cancellation </a --}}
                                        >
                                    </td>
                                </tr>
                                @endforeach
                                @php
                                $event = null
                                @endphp
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-lg-12">
                            {{-- <span class="wallet-title">You don't have any upcoming events</span> --}}
                                <a
                                    href="/"
                                    class="btn btn-dark text-light mt-5"
                                    >Explore Events Now</a
                                >
                        </div>
                    </div>
                    @endif
                    
                    @foreach ($upcoming_events as $event)
                    <div id="{{$event->id}}" class="event-details event-show">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="event-title mb-3">
                                {{$event->race->name}}<img
                                        class="close-icon event-details-trigger float-right"
                                        src="images/close-icon.svg"
                                        alt="close icon"
                                        onclick="hideevents()"
                                    />
                                </div>
                                <div class="event-sub-details mb-3">
                                    <img
                                        class="details-icon"
                                        src="images/calendar-icon.svg"
                                    />
                                    <span class="details-text"
                                        >{{ \Carbon\Carbon::parse($event->race->event->event_start)->format('F jS Y')}}</span
                                    >
                                </div>
                                <div class="event-sub-details mb-3">
                                    <img
                                        class="details-icon"
                                        src="images/location-icon.svg"
                                    />
                                    <span class="details-text"
                                        >{!! $event->race->event->city !!}, Egypt</span
                                    >
                                </div>
                                <div class="event-sub-details mb-3">
                                    <img
                                        class="details-icon"
                                        src="images/money-icon.svg"
                                    />
                                    <span class="details-text align-top">
                                        - Ticket Price: EGP {{$event->ticket->price}}
                                        <br />
                                        - Ticket Type: {{$event->ticket->name}}
                                        <br />
                                        - Total Cost: EGP
                                            @foreach ((array)json_decode($event->order['meta'], true) as $key => $value)
                                                @if (preg_match("/TFT/i", $key))
                                                    @if ($value['_ticket_id'] == $event->ticket->id)
                                                        {{$value['Price']}}
                                                    @endif
                                                @endif
                                            @endforeach
                                    </span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 mb-4">
                                <div class="custom-dropdown">
                                    <span
                                        class="dropdown-trigger"
                                        data-toggle="collapse"
                                        data-target="#upcoming_general_info_{{$event->id}}"
                                    >
                                        General info
                                    </span>
                                    <div
                                        class="dropdown-content collapse"
                                        id="upcoming_general_info_{{$event->id}}"
                                    >
                                        {!! $event->race->event->details !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="custom-dropdown">
                                    <span
                                        class="dropdown-trigger"
                                        data-toggle="collapse"
                                        data-target="#upcoming_destination_{{$event->id}}"
                                    >
                                        Destination
                                    </span>
                                    <div
                                        class="dropdown-content collapse"
                                        id="upcoming_destination_{{$event->id}}"
                                    >
                                        <ul class="mb-0">
                                            <li>City: {!! $event->race->event->city !!}</li>

                                            <li>Address: {!! $event->race->event->address !!}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-5">
                                    <hr class="line-separator" />
                                </div>
                                <div class="event-title mb-3">
                                    Race Details
                                </div>
                            <form method="POST" action="{{ route('questionanswerupdate') }}">
                                @csrf
                                <div class="row">
                                @foreach ($event->questionanswer as $qa)
                                <div class="col-lg-6 mb-4">
                                <div>{{$qa->question->question_text}}</div>
                                    <div class="input-group">
                                        @if (stripos($qa->question->answertype->type, 'countries') !== false)
                                        <select @if (!(
                                            stripos($qa->question->question_text, 'swimmer') !== false ||
                                            stripos($qa->question->question_text, 'runner') !== false ||
                                            stripos($qa->question->question_text, 'cyclist') !== false
                                            )) disabled @endif 
                                            @if (date("Y-m-d H:i:s") > max(array_column(json_decode($event->ticket->race->ticket, true), 'ticket_end')))
                                            disabled
                                            @endif
                                            name="{{$qa->id}}" required class="custom-select " placeholder="{{$qa->question->question_text}}">
                                        @foreach ((array)json_decode($countries) as $key => $country)
                                        <option @if ($qa->answer_value == $country->name) selected @endif value="{{$country->name}}">{{$country->name}}</option>
                                        @endforeach
                                        </select>
                                        @elseif (stripos($qa->question->answertype->type, 'dropdown') !== false)
                                        <select @if (!(
                                            stripos($qa->question->question_text, 'size') !== false || 
                                            stripos($qa->question->question_text, 'pace') !== false ||
                                            stripos($qa->question->question_text, 'swimmer') !== false ||
                                            stripos($qa->question->question_text, 'runner') !== false ||
                                            stripos($qa->question->question_text, 'cyclist') !== false ||
                                            stripos($qa->question->question_text, 'team') !== false
                                            ) ) disabled @endif 
                                            @if (date("Y-m-d H:i:s") > max(array_column(json_decode($event->ticket->race->ticket, true), 'ticket_end')))
                                            disabled
                                            @endif
                                            name="{{$qa->id}}" required class="custom-select " placeholder="{{$qa->question->question_text}}" sty>
                                        @foreach ($qa->question->answervalue as $answervalue)
                                        <option @if ($qa->answer_value == $answervalue->value) selected @endif value="{{$answervalue->value}}">{{$answervalue->value}}</option>
                                        @endforeach
                                        </select>
                                        @else
                                        <input @if (!(
                                            stripos($qa->question->question_text, 'size') !== false || 
                                            stripos($qa->question->question_text, 'pace') !== false ||
                                            stripos($qa->question->question_text, 'swimmer') !== false ||
                                            stripos($qa->question->question_text, 'runner') !== false ||
                                            stripos($qa->question->question_text, 'cyclist') !== false ||
                                            stripos($qa->question->question_text, 'team') !== false
                                            )) disabled @endif 
                                            @if (date("Y-m-d H:i:s") > max(array_column(json_decode($event->ticket->race->ticket, true), 'ticket_end')))
                                            disabled
                                            @endif
                                        name="{{$qa->id}}" required type="{{$qa->question->answertype->type}}" class="form-control " placeholder="{{$qa->question->question_text}}" value="{{$qa->answer_value}}"/>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                </div>
                                <div class="row">
                                    <span >Didn't receive tickets information on email? &nbsp;</span> 
                                    <a href="{{URL::to('sendmailqrcode',['event' => $event])}}" >Resend</a>
                                </div>
                                <input style="float:right" type="submit" class="btn btn-danger btn-block col-lg-6 mb-4" value="Submit Changes">
                            </form>
                            <div class="col-lg-12 mb-5">
                                    <hr class="line-separator" />
                                </div>
{{--                            @if (!(isset($event->participant_user) && $event->participant_user->id != $user->id))--}}
                            @if (isset($event->participant_user) )
                            <div style="margin: auto" class="col-lg-6 mt-4">
                                <form id="form_{{$event->id}}" action="{{ route('refund-ticket', ['userrace_id'=>$event->id, 'order_id'=>$event->order_id, 'race_id'=>$event->race_id, 'ticket_id'=>$event->ticket_id, 'user_id'=>$event->user_id, 'participant_user_id'=>$event->participant_user_id, 'participant_ticket_id'=>$event->participant_ticket_id]) }}" method="post">
                                    @csrf
                                    <input
                                        class="btn btn-danger btn-block trigger_cancel_event_modal"
                                        onclick="openconfirmcancelmodal({{$event->id}})"
                                        value="Cancel Event"
                                        type="button"
                                        id="cancel_{{$event->id}}"
                                        
                                        @if (!$event->race->event['cancel_availablility'])
                                            disabled
                                        @endif
                                    >
                                </form>
                                @if ($event->race->event['cancel_availablility'])
                                <p class="terms-text">
                                    You will be refunded in points according to
                                    eligibility & cancellation terms.
                                    <a style="cursor: pointer"
                                        >Read our terms & conditions here</a
                                    >
                                </p>
                                @else 
                                <p class="terms-text">
                                    Cancellation feature has ended for this event.
                                </p>
                                @endif
                            </div>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
                @foreach ($upcoming_events as $event)
                @php
                $general_ticket = \App\Ticket::where('race_id', $event->race_id)->where('name', 'like', '%general%' )->first();
                $general_ticket_ticket_end = $general_ticket['ticket_end'];
                $date_now = date("Y-m-d");
                @endphp
                <div class="modal fade custom-modal" id="confirm_cancel_event_modal_{{$event->id}}" tabindex="-1" role="dialog"
                aria-labelledby="phone_verify_modal" aria-hidden="true" data-backdrop="true" data-keyboard="false">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="header">
                                <!-- <h3 class="modal-title">Verification code sent to this number:</h3> -->
                                <!-- <img src="/images/success-icon.svg" class="modal-icon"> -->
                                <div class="modal-sub-title" style="color:#dc3545;font-size: 120%">Are you sure you want to Cancel your ticket?</div>
                                @if ($general_ticket_ticket_end < $date_now)
                                <span style="font-weight:bold">
                                    {{ $event->ticket->name }}<br><br>
                                    An amount of
                                    @foreach ((array)json_decode($event->order['meta'], true) as $key => $value)
                                            @if (preg_match("/TFT/i", $key)) 
                                                @if ($value['_ticket_id'] == $event->ticket->id)
                                                    <span>{{round($value['Price']*0.2, 0)}}</span>
                                                @endif
                                            @endif
                                        @endforeach
                                        will be refunded to your credit<br>and your race will be cancelled</span><br><br>
                                    **After the General registration deadline, 20% of the amount paid will be refunded
                                @else
                                <span style="font-weight:bold">
                                    {{ $event->ticket->name }}<br><br>
                                    An amount of
                                    @foreach ((array)json_decode($event->order['meta'], true) as $key => $value)
                                            @if (preg_match("/TFT/i", $key)) 
                                                @if ($value['_ticket_id'] == $event->ticket->id)
                                                <span>{{$value['Price']}} </span>
                                                @endif
                                            @endif
                                        @endforeach
                                        will be refunded to your credit<br>and your race will be cancelled</span>
                                @endif
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <img src="/images/close-icon.svg" alt="close icon" onclick="closeModal()">
                                </button>
                                </div>
                                <div class="content">
                                <p class="modal-text"></p>
                                <button onclick="opencancelmodal({{$event->id}})" class="btn btn-dark light">Confirm</button>
                                </div>
                                <br>
                </div>
                </div>
                </div>
                <div class="modal fade custom-modal" id="cancel_event_modal_{{$event->id}}" tabindex="-1" role="dialog"
                aria-labelledby="phone_verify_modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                        <div class="header">
                                <!-- <h3 class="modal-title">Verification code sent to this number:</h3> -->
                                <img src="/images/success-icon.svg" class="modal-icon">
                                <span class="modal-sub-title">{{ $event->ticket->name }} has been canceled<br><br>
                                    @foreach ((array)json_decode($event->order['meta'], true) as $key => $value)
                                            @if (preg_match("/TFT/i", $key)) 
                                                @if ($value['_ticket_id'] == $event->ticket->id)
                                                @if ($general_ticket_ticket_end < $date_now)
                                                {{round($value['Price']*0.2, 0)}}
                                                @else
                                                {{$value['Price']}}
                                                @endif
                                                @endif
                                            @endif
                                        @endforeach
                                    Points has been refunded to your credit</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <img src="/images/close-icon.svg" alt="close icon" onclick="refresh()">
                                </button>
                              </div>
                              <div class="content">
                                <p class="modal-text"></p>
                                <a href="/events" class="btn btn-dark light">Explore More Events</a>
                              </div>
                              <br>
                </div>
                </div>
                </div>
                @endforeach
                <!-- Previous Events -->
                <div
                    class="tab-pane"
                    id="pills-previous-events"
                    role="tabpanel"
                    aria-labelledby="pills-previous-events-tab"
                >
                    @if(count($past_events) > 0)
                    <div class="col-lg-12 table-responsive-lg">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Event</th>
                                    <th scope="col">Race</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Points</th>
                                    <th scope="col">Gender Rank</th>
                                    <th scope="col">Age Group Rank</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($past_events as $event)
                                @if (isset($event->race->event->name))
                                <tr>    
                                    <td scope="row">{{ $event->race->event->name }}</td>
                                    <td scope="row">{{ $event->race->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->race->event->event_start)->format('F jS Y')}}</td>
                                    <td>{{ $event->points }}</td>
                                    <td>{{ $event->gender_rank }}</td>
                                    <td>{{ $event->category_rank }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-lg-12">
                            {{-- <span class="wallet-title">You don't have any upcoming events</span> --}}
                                <a
                                    href="/"
                                    class="btn btn-dark text-light mt-5"
                                    >Explore Events Now</a
                                >
                        </div>
                    </div>
                    @endif
                </div>
                <!-- My Wallet -->
                <div
                    class="tab-pane"
                    id="pills-wallet"
                    role="tabpanel"
                    aria-labelledby="pills-wallet-tab"
                >
                    <div class="row">
                        <div class="col-lg-12">
                            <span class="wallet-title">You currently have</span>
                            <h3 class="wallet-value">
                                {{ $credit }} Credits (EGP {{ $credit }})
                            </h3>
                            <p class="wallet-text">
                                You can use these points to buy tickets for
                                events
                            </p>
                            <a
                                href="events"
                                class="btn btn-dark text-light mt-5"
                                >Explore Events Now</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End Content -->
@endsection
