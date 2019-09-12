<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\UserRace;
use App\Question;
use App\QuestionAnswer;
use App\Order;

class CreateUserRace
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $ticketId = $event->ticketId;
        $ticket = $event->ticket;
        $user = $event->user;
        $order = $event->order;
        $meta = json_decode($event->order->meta);

        $duplicate_count = UserRace::where('race_id', $meta->$ticketId->_race_id)
        ->where('ticket_id', $meta->$ticketId->_ticket_id)
        ->where('user_id', $user->id)->count();
        if ($duplicate_count >= 1) {
            return;
        }
        $participant_meta = json_decode(Order::find($order->id)['meta'], true)[$ticketId];
        $participant_email = $participant_meta['E-mail'];
        $participant_user = User::where('email', $participant_email)->first();

        $userRace = new UserRace;
        $userRace->order_id = $order->id;
        $userRace->participant_ticket_id = $ticketId;
        $userRace->participant_user_id = $participant_user['id'];
        $userRace->user_id = $user->id;
        $userRace->race_id = $meta->$ticketId->_race_id;
        $userRace->ticket_id = $meta->$ticketId->_ticket_id;
        $userRace->save();

        $metaArray =  (array) $meta->$ticketId;

        $metas = preg_filter('/^_qid(.*)/', '$1', array_keys($metaArray));
        $metas = array_values($metas);

        foreach ($metas as $meta) {
            $question = Question::where("id", $meta)
                            ->with('answertype', 'answervalue')
                            ->first();
                
            $answervalues = $question->answervalue()->get();

            $questionAnswer = new QuestionAnswer;
            $questionAnswer->userrace_id = $userRace->id;
            $questionAnswer->question_id = $meta;
            // for lists
            if (count($answervalues)) {
                $answer = $answervalues->firstWhere('id', $metaArray['_qid'.$meta]);
                $questionAnswer->answer_value = $answer->value;
            } else {
                $questionAnswer->answer_value = $metaArray['_qid'.$meta];
            }
            
            $questionAnswer->save();
        }
    }
}
