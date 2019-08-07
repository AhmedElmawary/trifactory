<?php

namespace App\Http\Controllers;

use App\Event;
use App\Race;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::with('eventimages')->past()->published()->get();
        $upcoming_events = Event::with('eventimages')->upcomming()->published()->get();
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json(['status' => 200, 'events' => $events, 'upcoming_events' => $upcoming_events]);
        } else {
            return view('events', ['events' => $events, 'upcoming_events' => $upcoming_events]);
        }
    }

    public function details($id)
    {
        $user = Auth::user();

        $event = Event::with('eventimages')->find($id);

        $today = Carbon::now();
        $pastEvent = false;

        if ($event->event_start < $today) {
            $pastEvent = true;
        }
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json([
                'event' => $event,
                'pastEvent' => $pastEvent,
                'user' => $user
            ]);
        } else {
            return view('event-details', [
                'event' => $event,
                'pastEvent' => $pastEvent,
                'user' => $user
            ]);
        }
    }

    public function getTicketsByRaceId($id)
    {
        $tickets = DB::table('tickets')
            ->where('race_id', $id)
            ->where('published', 'YES')->get();

        return response()->json($tickets);
    }

    public function getMetaByRaceId($id)
    {
        $raceQuestions = Race::where('id', $id)
            ->with('question', 'question.answertype', 'question.answervalue')
            ->get();
        $raceQuestions[0]['user'] = Auth::user();
        return response()->json($raceQuestions);
    }

    public function getCountries()
    {
        $nationalities = \countries();
        unset($nationalities['il']);

        return response()->json($nationalities);
    }
}
