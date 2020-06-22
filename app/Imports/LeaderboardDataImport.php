<?php

namespace App\Imports;

use App\LeaderboardData;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class LeaderboardDataImport implements
    OnEachRow,
    WithEvents,
    WithHeadingRow,
    WithCalculatedFormulas,
    WithChunkReading,
    ShouldQueue
{
    use Importable;

    public $sheetNames;
    public $sheetData;

    public function __construct()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 3000);
        $this->sheetName = null;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $row)
    {
        $row = $row->toArray(null, true, true);

        if (!stripos($this->sheetName, '-')) {
            return;
        }

        $sheetName = explode('-', $this->sheetName);

        $race_id = trim($sheetName[count($sheetName) - 1]);

        if (stripos($this->sheetName, 'relay') !== false) {
            $count = 0;
            foreach ($row as $key => $value) {
                if (stripos($key, 'name') !== false) {
                    $count++;
                }
            }
            $count = ($count == 0) ? $count = 1 : $count = $count;

            $data = [
                'race_id' => $race_id,
                'bib' => $row['bib'],
                'category' => $row['category'],
                'category_position' => $row['categoryposition'],

                'name' => $row['swimmer_name'],
                'email' => $row['swimmer_email'],
                'club' => $row['swimmer_club'],
                'gender' => $row['swimmer_gender'],
                'country_code' => $row['swimmer_countrycode'],
            ];

            $points = $row['points'] / $count ;
            $user = LeaderboardData::firstOrCreate($data);
            $user->points += $points;
            $user->save();

            $data = [
                'race_id' => $race_id,
                'bib' => $row['bib'],
                'category' => $row['category'],
                'category_position' => $row['categoryposition'],

                'name' => $row['runner_name'],
                'email' => $row['runner_email'],
                'club' => $row['runner_club'],
                'gender' => $row['runner_gender'],
                'country_code' => $row['runner_countrycode'],
            ];

            $points = $row['points'] / $count ;
            $user = LeaderboardData::firstOrCreate($data);
            $user->points += $points;
            $user->save();

            if ($count === 3) {
                $data = [
                    'race_id' => $race_id,
                    'bib' => $row['bib'],
                    'category' => $row['category'],
                    'category_position' => $row['categoryposition'],

                    'name' => $row['cyclist_name'],
                    'email' => $row['cyclist_email'],
                    'club' => $row['cyclist_club'],
                    'gender' => $row['cyclist_gender'],
                    'country_code' => $row['cyclist_countrycode'],
                ];

                $points = $row['points'] / $count ;
                $user = LeaderboardData::firstOrCreate($data);
                $user->points += $points;
                $user->save();
            }
        } else {
            $data = [
                'race_id' => $race_id,
                'bib' => $row['bib'],
                'name' => $row['name'],
                'email' => $row['email'],
                'club' => $row['club'],
                'gender' => $row['gender'],
                'category' => $row['category'],
                'country_code' => $row['countrycode'],
            ];

            if (isset($row['genderposition'])) {
                $data['gender_position'] = $row['genderposition'];
            }

            if (isset($row['categoryposition'])) {
                $data['category_position'] = $row['categoryposition'];
            }

            $points = $row['points'] ;
            $user = LeaderboardData::firstOrCreate($data);
            $user->points += $points;
            $user->save();
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $this->sheetName = $event->getSheet()->getTitle();
            }
        ];
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
