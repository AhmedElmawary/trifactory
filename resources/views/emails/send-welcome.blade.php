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
                With this account, you are officially a member of the Endurance League, the multi-sport ranking system that calculates points based on your performance at The TriFactory events and also other competitions that are part of the program. The Endurance League ranks each individual based on their overall finish position, age group ranking, and race completion. Athletes accumulate points at every race they compete in and complete, and are included in the overall yearly leaderboard. Athletes who participate as members of relay teams also accumulate points.
            </span>
        </td>
    </tr>
    <tr style="height:10px;"></tr>
    <tr>
        <td>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                Every athlete in the Endurance League should also indicate the endurance team or club that they belong to, and their points will also go towards the overall team leaderboard. 
            </span>
        </td>
    </tr>
    <tr style="height:10px;">
        <td>
            <span style="font-family: AvenirNext-Bold;font-size: 16px;color: #D31D00;">
                <a style="text-decoration:none; color: #D31D00;" href="{{url('/leaderboard')}}" >Click HERE</a>
            </span>
            <span style="font-family: AvenirNext-Medium;font-size: 12px;color: #474747;">
                to take a look at the Endurance League leaderboard.
            </span>
        </td>
    </tr>
@endsection