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
        return view('events', ['events' => $events]);
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

        return view('event-details', [
            'event' => $event,
            'pastEvent' => $pastEvent,
            'user' => $user
        ]);
    }

    public function getTicketsByRaceId($id)
    {
        $tickets = DB::table('tickets')
            ->where('race_id', $id)
            ->where('published', 'YES')->get();

        return json_encode($tickets);
    }

    public function getMetaByRaceId($id)
    {
        $raceQuestions = Race::where('id', $id)
            ->with('question', 'question.answertype', 'question.answervalue')
            ->get();
        $raceQuestions[0]['user'] = Auth::user();
        return json_encode($raceQuestions);
    }

    public function getCountries()
    {
        $nationalities = \countries();
        unset($nationalities['il']);

        return json_encode($nationalities);
    }
}
