<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use App\User;
use App\Question;
use App\Answervalue;

class UserTicketDetails extends DownloadExcel implements
    WithCustomValueBinder,
    WithMapping,
    WithHeadingRow,
    ShouldAutoSize
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function bindValue(Cell $cell, $value)
    {
        $cell->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        return true;
    }

    public function headings(): array
    {
        $questions = ['id', 'For', 'E-Mail', 'Phone', 'Event', 'Race', 'Order ID', 'Paymob ID'];
        return $questions;
    }

    public function map($order): array
    {
        ini_set('memory_limit', '-1');
        $order = json_decode($order, true);

        $result = array();
        
        if ($order['success'] == 'true') {
            // $result[] =
            // $result[] = strval("For: ").strval($order["meta"]);
            if (preg_match("/TFT/i", $order['id'])) {
                foreach (json_decode($order['meta'], true) as $key => $value) {
                    if (preg_match("/TFT/i", $key) && isset($value['E-mail'])) {
                        $record = array();
                        // foreach ($value as $key2 => $value2) {
                        $record[] = User::select('id')->where("email", $value['E-mail'])->first()['id'];
                        $record[] = $value['For'];
                        $record[] = $value['E-mail'];
                        $record[] = $value['Phone'];
                        $record[] = $value['Event'];
                        $record[] = $value['Race'];
                        $record[] = $order['id'];
                        $record[] = $order['paymob_order_id'];
                        
                        foreach ($value as $question => $answer) {
                            if (preg_match("/_qid/i", $question)) {
                                $question_id = substr($question, 4);
                                $q = Question::find($question_id)['question_text'];
                                if (is_int($answer)) {
                                    $a = Answervalue::find($answer);
                                    if ($a) {
                                        $a = $a["value"];
                                    }
                                } else {
                                    $a = $answer;
                                }
                                $record[] = $q.": ".$a;
                            }
                        }

                        $result[] = $record;
                        // }
                    }
                }
            }
        }
        return $result;
    }
}
