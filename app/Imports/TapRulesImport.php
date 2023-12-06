<?php

namespace App\Imports;

use App\Models\TapRules;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Collection;

class TapRulesImport implements ToCollection,WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
      foreach ($rows as $row)
      {
        TapRules::updateOrCreate(
          [
            'tap_1'    => $row[0],
            'tap_2'     => $row[1],
          ],
          [
            'tap_1'     => $row[0],
            'tap_2'     => $row[1],
            'rule'     => $row[2],
          ]
        );
      }
    }

    public function getCsvSettings(): array
{
    return [
        'delimiter' => ";"
    ];
}

}
