<?php

namespace App\Imports;

use App\Models\Tap;
use App\Models\SpeciesTaxId;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Collection;

class TapImport implements ToCollection,WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
      $rows->shift(); # skip first row of Collection - Header
      foreach ($rows as $row)
      {
        Tap::updateOrCreate(
          [
            'tap_id'    => $row[0],
          ],
          [
            'tap_id'    => $row[0],
            'tap_1'     => $row[1],
            'tap_2'     => $row[2],
            'count'     => $row[3],
            'tap_3'     => $row[4],
            // 'code_id'     => SpeciesTaxId::whereRaw('SUBSTRING_INDEX(code, "_",  1) = ?', [$row[5]])->first()->id ?? NULL,
            'code_id'     => SpeciesTaxId::where('code', strstr($row[0], "_", true))->first()->id ?? NULL,
          ]
        );
      }
    }

    // public function uniqueBy()
    // {
    //     return 'name';
    // }

    public function getCsvSettings(): array
{
    return [
        'delimiter' => ";"
    ];
}

}
