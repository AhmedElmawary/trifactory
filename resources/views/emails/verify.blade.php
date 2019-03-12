@extends('layouts.email')
@section('content')
    <tr>
        <td>
            <span style="font-family: AvenirNext-Bold;font-size: 24px;color: #000000;">
                Hello!
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>Please click the button below to verify your email address.</td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td><a style="text-decoration:none;display: inline-block;font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;user-select: none;border: 1px solid transparent;padding: .75rem 2rem;font-size: 1.125rem;line-height: 1.5;border-radius: 0;color: #fff;background-color: #e21c21;border-color: #e21c21;" href="{{ $verifyUrl }}">Verify Email</a></td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>If you did not create an account, no further action is required.</td>
    </tr>

@endsection