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
        $questions = ['id', 'name', 'email', 'phone', 'year_of_birth', 'club', 'event', 'race', 'ticket', 'order id'];
        return $questions;
    }

    public function map($userRace): array
    {
        if (empty($userRace->user()->get()[0]) ||
        empty($userRace->race()->get()[0]) ||
        empty($userRace->race()->get()[0]->event()->get()[0]) ||
        empty($userRace->ticket()->get()[0]) ||
        empty($userRace->order()->get()[0])) {
            return [];
        }
        \Log::info($userRace);
        $user = $userRace->user()->get()[0];
        $race = $userRace->race()->get()[0];
        $event = $userRace->race()->get()[0]->event()->get()[0];
        $ticket = $userRace->ticket()->get()[0];
        $order = $userRace->order()->get()[0];
        $answers = array();
        $answers[] = $user->id;
        $answers[] = $user->name;
        $answers[] = $user->email;
        $answers[] = $user->phone;
        $answers[] = $user->year_of_birth;
        $answers[] = $user->club;
        $answers[] = $event->name;
        $answers[] = $race->name;
        $answers[] = $ticket->name;
        $answers[] = $order->id;
        $question_answers = $userRace->questionanswer()->get();

        foreach ($question_answers as $qa) {
            $answers[] = strval($qa->question()->get()[0]->question_text).': '.strval($qa->answer_value);
        }

        // $answers = array_merge($answers, $userRace->questionanswer()->pluck('answer_value')->toArray());
        return $answers;
    }
}
