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
        $coming_soon_events = Event::with('eventimages')->comingSoon()->published()->get();

        if (\Request::is('api*') || \Request::wantsJson()) {
            foreach ($events as $event) {
                if (empty($event->event_start)) {
                    $event['formatted_date'] = "";
                } else {
                    $event['formatted_date'] = \Carbon\Carbon::parse($event->event_start)->format('j') .
                        (($event->event_start != $event->event_end) ? ' - ' .
                            \Carbon\Carbon::parse($event->event_end)->format('j M Y') :
                            \Carbon\Carbon::parse($event->event_end)->format(' M Y'));
                }
            }
            foreach ($upcoming_events as $upcoming_event) {
                if (empty($upcoming_event->event_start)) {
                    $upcoming_event['formatted_date'] = "";
                } else {
                    $upcoming_event['formatted_date'] = 
                        \Carbon\Carbon::parse($upcoming_event->event_start)->format('j') .
                            (($upcoming_event->event_start != $upcoming_event->event_end) ? ' - ' .
                                \Carbon\Carbon::parse($upcoming_event->event_end)->format('j M Y') :
                                \Carbon\Carbon::parse($upcoming_event->event_end)->format(' M Y'));
                }
            }
            foreach ($coming_soon_events as $coming_soon_event) {
                if (empty($coming_soon_event->event_start)) {
                    $coming_soon_event['formatted_date'] = "";
                } else {
                    $coming_soon_event['formatted_date'] = 
                        \Carbon\Carbon::parse($coming_soon_event->event_start)->format('j') .
                            (($coming_soon_event->event_start != $coming_soon_event->event_end) ? ' - ' .
                                \Carbon\Carbon::parse($coming_soon_event->event_end)->format('j M Y') :
                                \Carbon\Carbon::parse($coming_soon_event->event_end)->format(' M Y'));
                }
            }

            return response()->json([
                'status' => 200,
                'past_events' => $events,
                'upcoming_events' => $upcoming_events,
                'coming_soon_events' => $coming_soon_events
            ]);
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
        $coming_soon = $event->coming_soon;

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
        $eventDetails = $event->eventDetails;

        if (\Request::is('api*') || \Request::wantsJson()) {
            $event['formatted_date'] = \Carbon\Carbon::parse($event->event_start)->format('j') .
                (($event->event_start != $event->event_end) ? ' - ' .
                    \Carbon\Carbon::parse($event->event_end)->format('j M Y') :
                    \Carbon\Carbon::parse($event->event_end)->format(' M Y'));
            return response()->json([
                'event' => $event,
                'races' => $event->race()->get(),
                'pastEvent' => $pastEvent,
                'user' => $user,
                'closed' => $closed,
                'coming_soon' => $coming_soon,
                'eventDetails' => (count($eventDetails) > 0 ? $eventDetails : null)
            ]);
        } else {
            return view('event-details', [
                'event' => $event,
                'pastEvent' => $pastEvent,
                'user' => $user,
                'closed' => $closed,
                'coming_soon' => $coming_soon,
                'eventDetails' => (count($eventDetails) > 0 ? $eventDetails : null)
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
                'Line:' . __LINE__
                    . ';File:' . __FILE__
                    . ';Class:' . __CLASS__
                    . ';Method:' . __METHOD__
            ]);
        }
        if (\Request::is('api*')) {
            $swimmer = [];
            $runner = [];
            $cyclist = [];
            $others = [];
            foreach ($raceQuestions[0]['question'] as $rq) {
                if (stripos($rq->question_text, 'swimmer') !== false) {
                    $swimmer[] = $rq;
                } elseif (stripos($rq->question_text, 'cyclist') !== false) {
                    $cyclist[] = $rq;
                } elseif (stripos($rq->question_text, 'runner') !== false) {
                    $runner[] = $rq;
                } else {
                    $others[] = $rq;
                }
            }
            $i = 0;
            foreach ($raceQuestions[0]['question'] as $element) {
                unset($raceQuestions[0]['question'][$i]);
                $i++;
            }
            $raceQuestions[0]['question']['swimmer'] = $swimmer;
            $raceQuestions[0]['question']['runner'] = $runner;
            $raceQuestions[0]['question']['cyclist'] = $cyclist;
            $raceQuestions[0]['question']['others'] = $others;
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
