<?php

namespace App\Nova\Actions;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Race;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class UserQuestionsAnswers extends DownloadExcel implements
    WithCustomValueBinder,
    WithMapping,
    WithHeadingRow,
    ShouldAutoSize
{
    public function __construct(int $raceId)
    {
        $this->raceId = $raceId;
    }

    public function bindValue(Cell $cell, $value)
    {
        $cell->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        return true;
    }

    public function headings(): array
    {
        if (!isset($this->raceId)) {
            throw new \Exception('Please filter by race before extracting');
        }
        $questions = ['id', 'First Name', 'Last Name', 'E-Mail', 'Phone', 'Event', 'Race', 'Price', 'Order ID',
        'Ticket ID', 'Ticket Name', 'Paymob ID', 'Payment Methods', 'Promocode', 'Comments', 'Date Created'];
        $user_questions = Race::find($this->raceId)->question()->withPivot('race_question')
        ->where('question_id', '!=', 130)->pluck('question_text')->toArray();
        $user_questions[] = Race::find($this->raceId)->question()->withPivot('race_question')
        ->where('question_id', 130)->pluck('question_text')->first();
        $questions = array_merge($questions, $user_questions);
        
        return $questions;
    }

    public function map($userRace): array
    {
        if (!isset($this->raceId)) {
            throw new \Exception('Please filter by race before extracting');
        }

        // $answers = $userRace->questionanswer()->pluck('answer_value')->toArray();
        // return $answers;

        if (empty($userRace->user()->get()[0]) ||
        empty($userRace->race()->get()[0]) ||
        empty($userRace->race()->get()[0]->event()->get()[0]) ||
        empty($userRace->ticket()->get()[0]) ||
        empty($userRace->order()->get()[0])) {
            return [];
        }


        $user = $userRace->user()->get()[0];
        $race = $userRace->race()->get()[0];
        $event = $userRace->race()->get()[0]->event()->get()[0];
        $ticket = $userRace->ticket()->get()[0];
        $order = $userRace->order()->get()[0];

        $answers = array();
        $answers[] = $userRace->participant_user_id;
        $answers[] = strtok($user->name, " ");
        $answers[] = strstr($user->name, " ");
        $answers[] = $user->email;
        $answers[] = $user->phone;
        $answers[] = $event->name;
        $answers[] = $race->name;
        try {
            $answers[] = json_decode($order->meta, true)[$userRace->participant_ticket_id]['Price'];
        } catch (\Exception $e) {
            if (!isset($userRace->participant_ticket_id)) {
                $answers[] = 'N/A';
                // throw new \Exception('participant_ticket_id not set for UserRace: '.$userRace->id);
            }
        }
        $answers[] = $order->id;
        $answers[] = $userRace->participant_ticket_id;
        $answers[] = $ticket->name;
        $answers[] = $order->paymob_order_id;
        $answers[] = ((isset(json_decode($order['meta'], true)['credit'])) ?
        'C' : '').((isset(json_decode($order['meta'], true)['voucher'])) ?
        'V' : '').((isset(json_decode($order->meta, true)[$userRace->participant_ticket_id]['code'])) ? 'P' : '').'';
        $answers[] = (isset(json_decode($order->meta, true)[$userRace->participant_ticket_id]['code'])) ?
        json_decode($order->meta, true)[$userRace->participant_ticket_id]['code'] : '';
        $answers[] = $userRace->comment;
        $answers[] = $order->created_at;
        $question_answers = $userRace->questionanswer()->get();
        foreach ($question_answers as $qa) {
            $answers[] = strval($qa->answer_value);
        }
        return $answers;
    }
}
