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
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
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
        if (\Auth::check()) {
            $user = \Auth::user();
            \Cart::session($user->id);
        }
        $user = Auth::user();

        $event = Event::with('eventimages')->find($id);

        $today = Carbon::now();
        $pastEvent = false;
        $closed = true;
        
        if (!isset($event)) {
            abort(404);
        }

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
        if (Auth::user() && (Auth::user()->id == 465 || Auth::user()->id == 469 || Auth::user()->id == 1468)) {
            $tickets = DB::table('tickets')
                ->where('race_id', $id)->get();
            $tickets['exception_user'] = false;
            $tickets['admin'] = true;
        } else {
            $tickets = DB::table('tickets')
                ->where('race_id', $id)
                ->where('published', 'YES')->get();
            $tickets['exception_user'] = false;
            $tickets['admin'] = false;
        }
        // if (Auth::user() && (Auth::user()->id == 1430 || Auth::user()->id == 1867)) {
        //     $tickets['exception_user'] = true;
        // }
        return response()->json($tickets);
    }

    public function getMetaByRaceId($id)
    {
        $raceQuestions = Race::where('id', $id)
            ->with('question', 'question.answertype', 'question.answervalue')
            ->get();
        try {
            $raceQuestions[0]['user'] = Auth::user();
        } catch (\Exception $e) {
            \App\Exception::create([
                'message' => $e->getMessage(),
                'data' => json_encode($id),
                'location' =>
                'Line:'.__LINE__
                .';File:'.__FILE__
                .';Class:'.__CLASS__
                .';Method:'.__METHOD__
            ]);
        }
        return response()->json($raceQuestions);
    }

    public function getCountries()
    {
        $nationalities = \countries();
        unset($nationalities['il']);

        return response()->json($nationalities);
    }
}
