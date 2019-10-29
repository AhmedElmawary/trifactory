<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\RaceQuestion;
use App\User;
use App\Answervalue;
use App\Question;

class FixOrderData extends Action
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
        ini_set('max_execution_time', 180); //3 minutes
        foreach ($models as $order) {
            $order_copy = json_decode($order, true);
            if (preg_match("/TFT/i", $order_copy['id']) || preg_match("/TFO/i", $order_copy['id'])) {
                $new_meta = null;

                foreach (json_decode($order_copy['meta'], true) as $key => $value) {
                    $new_meta[$key] = $value;
                    if (preg_match("/TFT/i", $key) && isset($value['E-mail'])) {
                        $updated_ticket_details = null;     //updated meta inside the TFT ticket
                        $user = User::where("email", $value['E-mail'])->first();
                        $birth_exists = false;
                        $club_exists = false;
                        $other_exists = false;
                        foreach ($value as $question => $answer) {
                            if (preg_match("/year of birth/i", $question)) {
                                $birth_exists = true;
                            }
                            if (preg_match("/club/i", $question)) {
                                $club_exists = true;
                            }
                            if (preg_match("/other/i", $question)) {
                                $other_exists = true;
                            }
                        }
                        foreach ($value as $question => $answer) {
                            if (preg_match("/_qid/i", $question)) {
                                $question_id = substr($question, 4);
                                $q = Question::find($question_id);
                                if (preg_match("/gender/i", $q['question_text']) &&
                                !$birth_exists) {  // add the year of birth
                                    $race_questions = RaceQuestion::where('race_id', $value['_race_id'])->get();
                                    $birth_question_id = 0;
                                    $birth_question_text = '';
                                    
                                    foreach ($race_questions as $ques) {
                                        $quest = Question::find($ques['question_id']);
                                        if (preg_match("/year of birth/i", $quest['question_text'])) {
                                            $birth_question_id = $quest['id'];
                                            $birth_question_text = $quest['question_text'];
                                            break;
                                        }
                                    }
                                    $updated_ticket_details[$question] = $answer;
                                    $updated_ticket_details[$birth_question_text] = $user->year_of_birth;
                                    $updated_ticket_details["_qid".$birth_question_id] =
                                    Answervalue::where('value', $user->year_of_birth)->first()['id'];
                                } else {
                                    // add the club and others
                                    if (preg_match("/size/i", $q['question_text']) && !$club_exists && !$other_exists) {
                                        $race_questions = RaceQuestion::where('race_id', $value['_race_id'])->get();
                                        $club_question_id = 0;
                                        $club_question_text = '';
                                        $other_question_id = 0;
                                        $other_question_text = '';
                                        
                                        foreach ($race_questions as $ques) {
                                            $quest = Question::find($ques['question_id']);
                                            if (preg_match("/club/i", $quest['question_text'])) {
                                                $club_question_id = $quest['id'];
                                                $club_question_text = $quest['question_text'];
                                            }
                                            if (preg_match("/other/i", $quest['question_text'])) {
                                                $other_question_id = $quest['id'];
                                                $other_question_text = $quest['question_text'];
                                            }
                                        }
                                        $updated_ticket_details[$question] = $answer;
                                        if (isset($value[$club_question_text]) &&
                                        isset($value["_qid".$club_question_id])) {
                                            $updated_ticket_details[$club_question_text] =
                                            $value[$club_question_text];
                                            $updated_ticket_details["_qid".$club_question_id] =
                                            $value["_qid".$club_question_id];
                                        } else {
                                            $question_answers = Answervalue::where('question_id', $club_question_id)
                                            ->get();
                                            foreach ($question_answers as $qa) {
                                                if (preg_match("/other/i", $qa)) {
                                                    $user_club_id = $qa['id'];
                                                    $user_club_text = $qa['value'];
                                                }
                                            }
                                            foreach ($question_answers as $qa) {
                                                if (strtolower($user->club) == strtolower($qa['value'])) {
                                                    $user_club_id = $qa['id'];
                                                    $user_club_text = $qa['value'];
                                                }
                                            }
                                            $updated_ticket_details[$club_question_text] =
                                            $user_club_text;
                                            $updated_ticket_details["_qid".$club_question_id] =
                                            $user_club_id;
                                        }
                                        if (isset($value[$other_question_text]) &&
                                        isset($value["_qid".$other_question_id])) {
                                            $updated_ticket_details[$other_question_text] =
                                            $value[$other_question_text];
                                            $updated_ticket_details["_qid".$other_question_id] =
                                            $value["_qid".$other_question_id];
                                        } else {
                                            $user_other_id = null;
                                            $user_other_text = null;
                                            $question_answers = Answervalue::where('question_id', $club_question_id)
                                            ->get();
                                            $found = false;
                                            foreach ($question_answers as $qa) {
                                                if (strtolower($user->club) == strtolower($qa['value'])) {
                                                    $found = true;
                                                }
                                            }
                                            if (!$found) {
                                                $user_other_text = $user->club;
                                                $user_other_id = $user->club;
                                            }
                                            $updated_ticket_details[$other_question_text] = $user_other_text;
                                            $updated_ticket_details["_qid".$other_question_id] = $user_other_id;
                                        }
                                    } else {
                                        $updated_ticket_details[$question] = $answer;
                                    }
                                }
                            } else {
                                $updated_ticket_details[$question] = $answer;
                            }

                            $new_meta[$key] = $updated_ticket_details;
                        }
                    }
                }
                $order['meta'] = json_encode($new_meta);
                $order->save();
            }
        }
    }
}
