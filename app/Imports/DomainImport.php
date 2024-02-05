<?php

namespace App\Imports;

use App\Models\Domain;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Collection;

class DomainImport implements ToCollection,WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
      //$rows->shift(); # skip first row of Collection - Header
      foreach ($rows as $row)
      {
        if (str_starts_with($row[1], 'PF')){
          $pfam = $row[1];
        } else {
          $pfam = 'custom';
        }

        Domain::updateOrCreate(
          [
            'name'    => $row[0],
          ],
          [
            'name'    => $row[0],
            'pfam'     => $pfam,
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
