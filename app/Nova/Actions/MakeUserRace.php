<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Question;
use App\Answervalue;
use App\QuestionAnswer;
use App\Race;
use App\UserRace;

class MakeUserRace extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300); // 5 minutes
        foreach ($models as $order) {
            $order = json_decode($order, true);

            $result = array();
            
            if ($order['success'] == 'true' || strpos($order['success'], 'refund')) {
                if (preg_match("/TFT/i", $order['id']) || preg_match("/TFO/i", $order['id'])) {
                    foreach (json_decode($order['meta'], true) as $key => $value) {
                        if ((isset(UserRace::where('participant_ticket_id', $key)->first()['id']) &&
                            !isset(UserRace::where('participant_ticket_id', $key)->first()['participant_user_id'])) ||
                            (preg_match("/TFT/i", $key) && isset($value['E-mail']) &&
                            !strpos($order['success'], $key) &&
                            !isset(UserRace::where('participant_ticket_id', $key)->first()['id']))) {
                            $userrace = new UserRace();
                            $userrace->order_id = $order['id'];
                            $userrace->participant_ticket_id = $key;
                            $userId = User::select('id')
                                ->where("email", $value['E-mail'])
                                ->first()['id'];
                            if ($userId) {
                                $userrace->participant_user_id = $userId;
                            } else {
                                try {
                                    $user = new User();
                                    $names = explode(' ', $value['For']);
                                    $user->name = $value['For'];
                                    $user->firstname = isset($names[0]) ? $names[0] : '';
                                    $user->lastname = isset($names[1]) ? $names[1] : '';
                                    $user->email = $value['E-mail'];
                                    $user->phone = isset($value['Phone'])? $value['Phone'] : null;
                                    $user->nationality = isset($value['Nationality'])? $value['Nationality']: '';
                                    $user->save();
                                } catch (\Exception $e) {
                                    $user = new User();
                                    $names = explode(' ', $value['For']);
                                    $user->name = $value['For'];
                                    $user->firstname = isset($names[0]) ? $names[0] : '';
                                    $user->lastname = isset($names[1]) ? $names[1] : '';
                                    $user->email = $value['E-mail'];
                                    $user->save();
                                }
                                $userrace->participant_user_id = User::select('id')
                                    ->where("email", $value['E-mail'])
                                    ->first()['id'];
                            }
                            $userrace->race_id = $value['_race_id'];
                            $userrace->ticket_id = $value['_ticket_id'];
                            $userrace->user_id = $order['user_id'];

                            $old_userraces = UserRace::where('order_id', $order['id'])
                            ->where('race_id', $value['_race_id'])
                            ->where('ticket_id', $value['_ticket_id'])
                            ->where('user_id', $order['user_id']);
                            foreach ($old_userraces->get() as $old_userrace) {
                                if (!isset($old_userrace['participant_ticket_id'])
                                || !isset($old_userrace['participant_user_id'])) {
                                    $old_userrace->delete();
                                }
                            }
                            $userrace->save();


                            foreach ($value as $question => $answer) {
                                if (preg_match("/_qid/i", $question)) {
                                    $question_id = substr($question, 4);
                                    $q_id = Question::find($question_id)['id'];
                                    $q = Question::find($question_id)['question_text'];
                                    if (is_int($answer)) {
                                        $a = Answervalue::find($answer);
                                        if ($a) {
                                            $a = $a["value"];
                                        }
                                    } else {
                                        $a = $answer;
                                    }
                                    if (preg_match("/club/i", $q) && empty($a)) {
                                        $a = $value[$q];
                                    }
                                    if (preg_match("/others/i", $q) && empty($a)) {
                                        $a = $value["_qid".$question_id];
                                    }
                                    $record[] = $a;
                                    QuestionAnswer::create([
                                        'userrace_id' => $userrace->id,
                                        'question_id' => $q_id,
                                        'answer_value' => $a
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            // return $result;
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
