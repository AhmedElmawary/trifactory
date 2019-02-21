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
            <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                Congratulations, 
            </span>
            <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                {{ $user->name }}
            </span>
            <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                have gifted you a voucher to use in any of The TriFactory's current or upcoming races.
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                <blockquote style="font-family: AvenirNext-Medium;font-size: 22px;color: #474747;">
                    "{{ $meta->message }}"
                </blockquote>
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                <b>Voucher Code: </b>
            </span>
            <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                {{ $voucher->code }}
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                This voucher can be used for one time only when registering in our races. In the case you did not use the full voucher amount, the rest of the amount not used will remain in your credit balance to be used in any upcoming races you wish to register to.
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                Looking forward to seeing you in our events.
            </span>
        </td>
    </tr>
@endsection
          