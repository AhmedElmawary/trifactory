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
        @elseif($ticket->_race_id == 56 || $ticket->_race_id == 59)
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 25px;color: red; text-decoration: underline; font-weight:600">
                    <?php $ticket_type = "Ticket Type" ?> 
                       {{$ticket->$ticket_type}} 
                </span><br>
            </td>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 19px;color: #000000;">
                How to Start Your Stay Safe Series | {{$ticket->$ticket_type}} 
                </span><br>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    1. DOWNLOAD APP
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 16.6px;color: #000000;line-height: 22px;">
                After you complete the registration download My Virtual Mission app from Apple Store or Google Play and wait for your
                invitation to join the {{$ticket->$ticket_type}} .
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    2. JOIN THE MISSION
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 16.6px;color: #000000;line-height: 25px;">
                    To Join the mission, Click on the link below  <br>
                   <?php  
                   
                        if ($ticket->_ticket_id == 125 || $ticket->_ticket_id == 131) 
                                        $link = "https://www.myvirtualmission.com/missions/52718/50km-stay-safe-marathon";  
                        if ($ticket->_ticket_id == 126 || $ticket->_ticket_id == 132) 
                                        $link = "https://www.myvirtualmission.com/missions/52719/100km-stay-safe-marathon";            
                        if ($ticket->_ticket_id == 133 || $ticket->_ticket_id == 137) 
                                        $link = "https://www.myvirtualmission.com/missions/52721/100km-stay-safe-cycling-challenge";  
                        if ($ticket->_ticket_id == 134 || $ticket->_ticket_id == 138) 
                                        $link = "https://www.myvirtualmission.com/missions/52722/200km-stay-safe-cycling-challenge";  
                        if ($ticket->_ticket_id == 135 || $ticket->_ticket_id == 139) 
                                        $link = "https://www.myvirtualmission.com/missions/52723/150km-stay-safe-endurance-challenge";  
                        if ($ticket->_ticket_id == 136 || $ticket->_ticket_id == 140) 
                                        $link = "https://www.myvirtualmission.com/missions/52724/250km-stay-safe-endurance-challenge";  
                        if ($ticket->_ticket_id == 141 ) 
                                        $link = "https://www.myvirtualmission.com/missions/53505/25km-stay-safe-marathon";  

                            ?>
                        {{$link}}<br>
                    Make sure to Click on "Join Mission" when you receive the invitation email.<br>
                    After clicking on "Join Mission", wait for your invitation to be accepted on the app within 24 hours.<br>
               </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    3. CONNECT APP
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 16.6px;color: #000000;line-height: 22px;">
                Final step is to connect the My Virtual Mission App to your preferred fitness app through 'My Connections' in the menu of your app to record your distance.
                You can also choose to add the distance you run/walk manually to your profile instead.
                Please note that your progress on the My Virtual Mission app gets updated every <u> 6 HOURS </u>, so please be patient.
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    4. RUN
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 16.6px;color: #000000;line-height: 22px;">
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

    @elseif($ticket->_race_id == 53 || $ticket->_race_id == 54)
        
    @php
        $url = "#";
        $title = "-";
        
        if($ticket->_ticket_id == 117) {
            $url = "https://www.myvirtualmission.com/missions/47858/stay-safe-marathon-50km-individual";
            $title = "50 KM Individual Ticket";    
        }
        elseif($ticket->_ticket_id == 118) {
            $url = "https://www.myvirtualmission.com/missions/47860/stay-safe-marathon-100km-individual";
            $title = "100 KM Individual Ticket";
        }
        elseif($ticket->_ticket_id == 119) {
            $title = "200 KM Team Ticket";
            $url = "https://www.myvirtualmission.com/missions/47864/stay-safe-marathon-200km-team-challenge";
        }
        elseif($ticket->_ticket_id == 120) {
            $url = "https://www.myvirtualmission.com/missions/47868/stay-safe-marathon-400km-team-challenge";
            $title = "400 KM Team Ticket";
        }
    @endphp

        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 28px;color: #b30000;">
                    {{$title}}
                </span><br>
            </td>
        </tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 26x;color: #000000;">
                    How to Start Your Stay Safe Marathon | Ramadan Edition 
                </span><br>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    1. DOWNLOAD APP
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 18px;color: #000000;line-height: 22px;">
                    After you complete the registration download My Virtual Mission app from Apple Store or Google Play and wait for your invitation to join the <b> Stay Safe Marathon | Ramadan Edition</b>.
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    2. JOIN THE MISSION
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 14px;color: #000000;line-height: 22px;">
                    To Join the mission, Click on the link below <br>
                    {{$url}}<br> 
                    Make sure to Click on <b>"Join Mission"</b> when you receive the invitation email.
                    After clicking on <b>"Join Mission"</b>, wait for your invitation to be accepted  on the app within 24 hours.
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    3. CONNECT APP
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 18px;color: #000000;line-height: 22px;">
                    Final step is to connect the My Virtual Mission App to your preferred fitness app through <b>'My Connections'</b> in the menu of your app to record your distance.

                    You can also choose to add the distance you run/walk manually to your profile instead.
                    Please note that your progress on the My Virtual Mission app gets updated every <u>6 HOURS,</u> so please be patient.
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
        <tr style="height:10px;"></tr>
        <tr>
            <td>
                <span style="font-family: AvenirNext-Bold;font-size: 20px;color: #000000;line-height: 22px;">
                    4. RUN
                </span><br>
                <span style="font-family: AvenirNext-Medium;font-size: 18px;color: #000000;line-height: 22px;">
                    Finally all you have to do now is to start running or walking indoors or outdoors. Try to share your runs and progress using #ItsWorthATri and tagging <a target="_blank" href="https://www.instagram.com/thetrifactory/" >@thetrifactory</a>!
                </span>
            </td>
        </tr>
        <tr style="height:10px;"></tr>
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