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
                Thank you for signing up to The TriFactory.
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                Now you can access and keep track of your race results and ranking through your
            </span>
        </td>
    </tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                <a style="text-decoration:none; color: #D31D00;" href="{{url('/profile')}}" >account page</a>
            </span>
            <span style="font-family: AvenirNext-Medium;font-size: 16px;color: #000000;line-height: 22px;">
                .
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                With this account, you are officially enrolled in The TriFactory Ranking Program. Brief Description of the program: The program ranks each individual per their age group. Athletes generate points by registering in any of The TriFactory races and their finish time behind the first official finisher in their age group. Athletes accumulate points at every race they complete and included in the leaderboard on a yearly basis.
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                When an Athletes link their accounts with a team (the Trifactory, PowerRide,… etc.), their total points of the year will be added to the total team points giving them the chance to compete on The TriFactory’s leaderboard.
            </span>
        </td>
    </tr>
@endsection