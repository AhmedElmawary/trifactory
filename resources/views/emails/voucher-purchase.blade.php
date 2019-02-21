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
                You have successfully purchased a voucher amounting to
            </span>
            <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                EGP {{ $meta->discount_amount }}
            </span>
            <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                for
            </span>
            <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                {{ $meta->recipient_name }}.
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                The holder of this voucher will be able to use it for any of The TriFactory's current and upcoming races for one time only.
            </span>
        </td>
    </tr>
@endsection