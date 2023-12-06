<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;

use App\Models\Clade;
use App\Models\Kingdom;
use App\Models\Family;
use App\Models\Supergroup;
use App\Models\Order;

class TaxImport implements ToCollection,WithCustomCsvSettings
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
      Clade::updateOrCreate(
        [
          'clade'    => $row[0],
        ],
        [
          'clade'    => $row[0],
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
