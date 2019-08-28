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
use App\Race;

use Maatwebsite\Excel\Facades\Excel;
use Laravel\Nova\Http\Requests\ActionRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Laravel\Nova\Fields\Number;

class UserTicketDetails extends DownloadExcel implements
    WithCustomValueBinder,
    WithMapping,
    WithHeadingRow,
    ShouldAutoSize
{
    use InteractsWithQueue, Queueable, SerializesModels;

        /**
     * @param ActionRequest $request
     * @param Action        $exportable
     *
     * @return array
     */
    public function handle(ActionRequest $request, Action $exportable): array
    {
        $this->race_id = $request->race_id;
        $response = Excel::download(
            $exportable,
            $this->getFilename(),
            $this->getWriterType()
        );

        if (!$response instanceof BinaryFileResponse || $response->isInvalid()) {
            return \is_callable($this->onFailure)
                ? ($this->onFailure)($request, $response)
                : Action::danger(__('Resource could not be exported.'));
        }

        return \is_callable($this->onSuccess)
            ? ($this->onSuccess)($request, $response)
            : Action::download(
                $this->getDownloadUrl($response),
                $this->getFilename()
            );
    }

    public function bindValue(Cell $cell, $value)
    {
        $cell->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        return true;
    }

    public function headings(): array
    {
        $questions = ['id', 'For', 'E-Mail', 'Phone', 'Event', 'Race', 'Order ID', 'Paymob ID'];
        $user_questions = Race::find($this->race_id)->question()->pluck('question_text')->toArray();
        $questions = array_merge($questions, $user_questions);

        return $questions;
    }

    public function map($order): array
    {
        $order = json_decode($order, true);

        $result = array();
        
        if ($order['success'] == 'true') {
            // $result[] =
            // $result[] = strval("For: ").strval($order["meta"]);
            if (preg_match("/TFT/i", $order['id'])) {
                foreach (json_decode($order['meta'], true) as $key => $value) {
                    if (preg_match("/TFT/i", $key) && isset($value['E-mail']) && $value['_race_id'] == $this->race_id) {
                        $record = array();
                        // foreach ($value as $key2 => $value2) {
                        $record[] = User::select('id')->where("email", $value['E-mail'])->first()['id'];
                        $record[] = $value['For'];
                        $record[] = $value['E-mail'];
                        $record[] = $value['Phone'];
                        $record[] = $value['Event'];
                        $record[] = $value['Race'];
                        $record[] = $order['id'];
                        $record[] = $value['Ticket Type'];
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
                                if (preg_match("/club/i", $q) && empty($a)) {
                                    $a = $value[$q];
                                }
                                if (preg_match("/others/i", $q) && empty($a)) {
                                    $a = $value[$q];
                                }
                                $record[] = $a;
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

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Number::make('Race ID')
        ];
    }
}
