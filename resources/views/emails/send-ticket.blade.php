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
                    <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">{{$ticket->Event}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">.  This is your registration confirmation for </span>   
                    <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">{{$ticket->Event}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">.</span> 
                @else
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        You successfully registered in
                    </span>
                    <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">{{$ticket->Event}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">, a ticket to </span>   
                    <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">{{$ticket->Race}}</span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        for 
                    </span> 
                    <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                        {{$ticket->For}}
                    </span>
                @endif
            @else
                @if($fromUser)
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        You successfully registered to
                    </span>
                    <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                        {{ $fromUser->name }}
                    </span>
                    <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                        to 
                    </span>   
                    <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">{{$ticket->Race}}</span>
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
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;">
                            <b>{{ $ticketId }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Event: </b>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;">
                            <b>{{ $ticket->Event }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Race: </b>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;">
                            <b>{{ $ticket->Race }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Participant Name: </b>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;">
                            <b>{{ $ticket->For }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Price: </b>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;">
                            <b>EGP {{ $ticket->Price }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Payment Method: </b>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;">
                            <b>
                                @if($ticket->paymentMethod === 'card')
                                    Credit Card.
                                @else
                                    Cash
                                @endif
                            </b>
                        </span>
                    </li>
                </ol>
            </span>
        </td>
    </tr>
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
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                @if($other) 
                    @if($newAccount) 
                        To complete your account and benefit from the The TriFactory’s ranking program, <a style="text-decoration: none;color: #D31D00;" href="{{ url('/password/reset') }}">click here</a>
                    @else
                        To access your account and benefit from the The TriFactory’s ranking program, <a style="text-decoration: none;color: #D31D00;" href="{{ url('/login') }}">click here</a>
                    @endif
                @endif
            </span>
        </td>
    </tr>
@endsection