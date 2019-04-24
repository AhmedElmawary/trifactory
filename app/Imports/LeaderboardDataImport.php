<?php

namespace App\Imports;

use App\LeaderboardData;

// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class LeaderboardDataImport implements OnEachRow, WithEvents, WithHeadingRow, WithCalculatedFormulas
{
    use Importable;

    public $sheetNames;
    public $sheetData;

    public function __construct()
    {
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

        if (stripos($this->sheetName, 'relay')) {
            $names = explode('/', $row['name']);
            $count = count($names);

            $data = [
                'race_id' => $race_id,
                'bib' => $row['bib'],
                'category' => $row['category'],
                'category_position' => $row['categoryposition'],
                'points' => $row['points'] / $count,
                'name' => $row['swimmer_name'],
                'email' => $row['swimmer_email'],
                'club' => $row['swimmer_club'],
                'gender' => $row['swimmer_gender'],
                'country_code' => $row['swimmer_countrycode'],
            ];
            LeaderboardData::firstOrCreate($data);

            $data = [
                'race_id' => $race_id,
                'bib' => $row['bib'],
                'category' => $row['category'],
                'category_position' => $row['categoryposition'],
                'points' => $row['points'] / $count,
                'name' => $row['runner_name'],
                'email' => $row['runner_email'],
                'club' => $row['runner_club'],
                'gender' => $row['runner_gender'],
                'country_code' => $row['runner_countrycode'],
            ];
            LeaderboardData::firstOrCreate($data);

            if ($count === 3) {
                $data = [
                    'race_id' => $race_id,
                    'bib' => $row['bib'],
                    'category' => $row['category'],
                    'category_position' => $row['categoryposition'],
                    'points' => $row['points'] / $count,
                    'name' => $row['cyclist_name'],
                    'email' => $row['cyclist_email'],
                    'club' => $row['cyclist_club'],
                    'gender' => $row['cyclist_gender'],
                    'country_code' => $row['cyclist_countrycode'],
                ];
                LeaderboardData::firstOrCreate($data);
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
                'points' => $row['points'],
            ];

            if (isset($row['genderposition'])) {
                $data['gender_position'] = $row['genderposition'];
            }

            if (isset($row['categoryposition'])) {
                $data['category_position'] = $row['categoryposition'];
            }

            LeaderboardData::firstOrCreate($data);
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
}
