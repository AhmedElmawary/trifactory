<?php

namespace App\Http\Controllers;

use App\Event;
use App\Race;
use App\Ticket;
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
        $closed = true;
        
        foreach ($event->race()->get() as $race) {
            $race_tickets = $race->ticket()->get();
            foreach ($race_tickets as $race_ticket) {
                if ($race_ticket->ticket_end > date('Y-m-d H:i:s') && $race_ticket->published == 'yes') {
                    $closed = false;
                }
            }
        }

        if ($event->event_start < $today) {
            $pastEvent = true;
        }
        if (\Request::is('api*') || \Request::wantsJson()) {
            return response()->json([
                'event' => $event,
                'pastEvent' => $pastEvent,
                'user' => $user,
                'closed' => $closed
            ]);
        } else {
            return view('event-details', [
                'event' => $event,
                'pastEvent' => $pastEvent,
                'user' => $user,
                'closed' => $closed
            ]);
        }
    }

    public function getTicketsByRaceId($id)
    {
        if (Auth::user() && (Auth::user()->id == 465 || Auth::user()->id == 469)) {
            $tickets = DB::table('tickets')
                ->where('race_id', $id)->get();
            $tickets['admin'] = true;
        } else {
            $tickets = DB::table('tickets')
                ->where('race_id', $id)
                ->where('published', 'YES')->get();
            $tickets['admin'] = false;
        }
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
