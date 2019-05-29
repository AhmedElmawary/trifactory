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
        $questions = Race::find($this->raceId)->question()->pluck('question_text')->toArray();
        return $questions;
    }

    public function map($userRace): array
    {
        $answers = $userRace->questionanswer()->pluck('answer_value')->toArray();
        return $answers;
    }
}
