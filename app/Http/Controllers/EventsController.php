<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Race;

use DB;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::with('eventimages')->published()->get();
        return view('events', ['events' => $events]);
    }

    public function details($id)
    {
        $event = Event::find($id)->with('eventimages')->first();
        return view('event-details', ['event' => $event]);
    }

    public function getTicketsByRaceId($id)
    {
        $tickets = DB::table("tickets")->where("race_id", $id)->pluck("name", "id");
        return json_encode($tickets);
    }

    public function getMetaByRaceId($id)
    {
        
        $raceQuestions = Race::where('id', $id)
        ->with('question', 'question.answertype', 'question.answervalue')
        ->get();
        
        return json_encode($raceQuestions);
    }
}
