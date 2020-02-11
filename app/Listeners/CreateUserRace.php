<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\UserRace;
use App\Question;
use App\QuestionAnswer;
use App\Order;
use Hash;

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
        $email = 'E-mail';

        $duplicate_count = UserRace::where('participant_ticket_id', $ticketId)->count();
        if ($duplicate_count >= 1) {
            return;
        }
        $participant_meta = json_decode(Order::find($order->id)['meta'], true)[$ticketId];
        $participant_email = $participant_meta['E-mail'];
        $participant_user = User::where('email', $participant_email)->first();
        if(is_null($participant_user))
        {
            $name = explode(" ", $ticket->For);
            if (!$name[1]) {
                $name[1] = '';
            }

            $nationality = null;
            $year_of_birth = 0;
            $club = '';

            foreach ($ticket as $key => $value) {
                if (preg_match("/nationality/i", $key)) {
                    $nationalities = \countries();
                    unset($nationalities['il']);
                    $nationality = $value;
                    foreach ($nationalities as $key => $n) {
                        if ($n['name'] == $value) {
                            $nationality = $n['iso_3166_1_alpha2'];
                        }
                    }
                }
                if (preg_match("/year of birth/i", $key)) {
                    $year_of_birth = $value;
                }
                if (preg_match("/club/i", $key)) {
                    $club = $value;
                }
                if (preg_match("/others/i", $key)) {
                    if ($value) {
                        $club = $value;
                    }
                }
            }

            $participant_user = User::create([
                'name' => $ticket->For,
                'firstname' => $name[0],
                'lastname' => $name[1],
                'email' => $ticket->$email,
                'nationality' => $nationality,
                'year_of_birth' => $year_of_birth,
                'club' => $club,
                'phone' => $ticket->Phone,
                'password' => Hash::make(uniqid('TFP')),
            ]);
        }

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
