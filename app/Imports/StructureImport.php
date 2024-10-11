<?php

namespace App\Imports;

use App\Models\Structure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Collection;

class StructureImport implements ToCollection,WithCustomCsvSettings
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

        Structure::updateOrCreate(
          [
            'family' => $row[0],
          ],
          [
            'family' => $row[0],
            'structure_superclass' => $row[1],
            'structure_class' => $row[2],
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
