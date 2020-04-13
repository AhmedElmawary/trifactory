@extends('layouts.email')
@section('content')
    <tr>
        <td>
            <span style="font-family: AvenirNext-Bold;font-size: 24px;color: #000000;">
                Dear {{ $user->name }},
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            @if($other === false)
                @if($self)
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        Thank you for registering in 
                    </span>
                    <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Bold;font-size: 16px;color: #474747;" @else style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" @endif>{{$ticket->Event}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">.  This is your registration confirmation for </span>   
                    <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Bold;font-size: 16px;color: #474747;" @else style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" @endif>{{$ticket->Event}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">.</span> 
                @else
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        You successfully registered in
                    </span>
                    <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Bold;font-size: 16px;color: #474747;" @else style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" @endif>{{$ticket->Event}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">, a ticket to </span>   
                    <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Bold;font-size: 16px;color: #474747;" @else style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" @endif>{{$ticket->Race}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        for 
                    </span> 
                    <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Bold;font-size: 16px;color: #474747;" @else style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" @endif>
                        {{$ticket->For}}
                    </span>
                @endif
            @else
                @if($fromUser)
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        You successfully registered to
                    </span>
                    <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Bold;font-size: 16px;color: #474747;" @else style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" @endif>
                        {{$ticket->Race}}
                    </span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        by 
                    </span>   
                    <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Bold;font-size: 16px;color: #474747;" @else style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" @endif>{{ $fromUser->name }}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">.</span> 
                @endif
            @endif
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                Ticket Information:
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                <ol>
                        <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Ticket ID: </b>
                        </span>
                        <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;" @else style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" @endif>
                            <b>{{ $ticketId }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Event: </b>
                        </span>
                        <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;" @else style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" @endif>
                            <b>{{ $ticket->Event }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Race: </b>
                        </span>
                        <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;" @else style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" @endif>
                            <b>{{ $ticket->Race }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Participant Name: </b>
                        </span>
                        <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;" @else style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" @endif>
                            <b>{{ $ticket->For }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Price: </b>
                        </span>
                        <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;" @else style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" @endif>
                            <b>EGP {{ $ticket->Price }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Payment Method: </b>
                        </span>
                        <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;" @else style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" @endif>
                            <b>
                                @if($ticket->paymentMethod === 'card')
                                    Credit Card.
                                @else
                                    Cash
                                @endif
                            </b>
                        </span>
                    </li>

                     <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>QR Code: </b>
                            <br/>
                        </span>
                        <span @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;" @else style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" @endif>
                           <img src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl={{$ticketId}}}"/>
                        </span>
                    </li>

                </ol>
            </span>
        </td>
    </tr>

    @if($ticket->_race_id == 52)
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 28px;color: #000000;">
                    How to Start Your Stay Safe Marathon 
                </span><br>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    1. DOWNLOAD APP
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 18px;color: #000000;line-height: 22px;">
                    After you complete the registration download My Virtual Mission app and <a style="font-family: AvenirNext-Medium;font-size: 14px;" href="https://www.myvirtualmission.com/missions/46047/stay-safe-marathon" target="_blank">click here</a> to join the Stay Safe Marathon. Your request to enter the mission will be accepted only after you successfully complete the registration as explained in step 1 above. It takes up to 24 hours for requests to be approved on the system.
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    2. JOIN THE MISSION
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #000000;line-height: 22px;">
                    Go to the below link and click on "Join Mission: at the bottom of the page <br>
                    https://www.myvirtualmission.com/missions/46047/stay-safe-marathon <br>
                    Your request will be approved within 24 hours. 
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    3. CONNECT APP
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 18px;color: #000000;line-height: 22px;">
                    Final step is to connect the My Virtual Mission App to your preferred fitness app through 'My Connections' in the menu of your app to record your distance.
                    You can also choose to add the distance you run/walk manually to your profile instead.
                    Please note that your progress on the My Virtual Mission app gets updated every <u>6 HOURS,</u> so please be patient.
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    4. RUN
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 18px;color: #000000;line-height: 22px;">
                    Finally all you have to do now is to start running or walking indoors or outdoors. Try to share your runs and progress using #ItsWorthATri and tagging <a target="_blank" href="https://thetrifactory.us14.list-manage.com/track/click?u=fa613f6bbc04ad2c6dfccc12b&id=4032e36b48&e=f7d672b0a8" >@thetrifactory</a>!
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;">
                    STAY SAFE STAY ACTIVE! 
                </span>
            </td>
        </tr>
    @endif

    @if($ticket->paymentMethod === 'cash')
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                Your race ticket will be confirmed and a race number will be assigned when the payment is completed successfully.<br>
            </span>
        </td>
    </tr>
    @endif
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12   px;color: #474747;">
                @if($other) 
                    @if($newAccount) 
                        To complete your account and benefit from the The TriFactory’s ranking program, <a @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="text-decoration: none;color: #474747;" @else style="text-decoration: none;color: #D31D00;" @endif href="{{ url('/password/reset') }}">click here</a>
                    @else
                        To access your account and benefit from the The TriFactory’s ranking program, <a @if (isset($ticket->Event) && preg_match("/mudder/i", $ticket->Event)) style="text-decoration: none;color: #474747;" @else style="text-decoration: none;color: #D31D00;" @endif href="{{ url('/login') }}">click here</a>
                    @endif
                @endif
            </span>
        </td>
    </tr>
@endsection