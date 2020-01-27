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
            @if($user)
                <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                    You successfully registered to
                </span>
                <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;" >
                    {{$race->name}}
                </span>
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
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" >
                            <b>{{ $event->name }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Race: </b>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" >
                            <b>{{ $race->name }}</b>
                        </span>
                    </li>
                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>Participant Name: </b>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" >
                            <b>{{ $user->name }}</b>
                        </span>
                    </li>

                    <li style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                            <b>QR Code: </b>
                            <br/>
                        </span>
                        <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #D31D00;" >
                           <img
                                   src="https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl={{$ticketId}}}"
                           />
                        </span>
                    </li>
                </ol>
            </span>
        </td>
    </tr>
@endsection