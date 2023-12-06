<?php

namespace App\Imports;

use App\Models\TapInfo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Collection;

class TapInfoImport implements ToCollection,WithCustomCsvSettings
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
        TapInfo::updateOrCreate(
          [
            'tap'    => $row[0],
          ],
          [
            'tap'    => $row[0],
            'text'     => $row[1],
            'reference'     => $row[2],
            'type'     => $row[3],
          ]
        );
      }
    }

    public function getCsvSettings(): array
{
    return [
        'delimiter' => "\t"
    ];
}

}
