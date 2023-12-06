<?php

namespace App\Imports;

use App\Models\SpeciesTaxId;
use App\Models\Family;
use App\Models\Order;
use App\Models\Supergroup;
use App\Models\Clade;
use App\Models\Kingdom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Collection;

class SpeciesImport implements ToCollection,WithCustomCsvSettings
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

        Kingdom::updateOrCreate(
          [
            'kingdom'    => $row[1],
          ],
          [
            'kingdom'     => $row[1],
          ]
        );

        Clade::updateOrCreate(
          [
            'clade'    => $row[2],
          ],
          [
            'clade'     => $row[2],
            'kingdom_id'     =>  Kingdom::where('kingdom',$row[1])->first()->id ?? NULL,
          ]
        );

        Supergroup::updateOrCreate(
          [
            'supergroup'    => $row[3],
          ],
          [
            'supergroup'     => $row[3],
            'clade_id'     =>  Clade::where('clade',$row[2])->first()->id ?? NULL,
          ]
        );

        Order::updateOrCreate(
          [
            'order'    => $row[4],
          ],
          [
            'order'     => $row[4],
            'supergroup_id' => Supergroup::where('supergroup',$row[3])->first()->id ?? NULL,
          ]
        );

        Family::updateOrCreate(
          [
            'family'    => $row[5],
          ],
          [
            'family'     => $row[5],
            'order_id'     =>  Order::where('order',$row[4])->first()->id ?? NULL,
          ]
        );

        SpeciesTaxId::updateOrCreate(
          [
            'taxid'    => $row[7],
          ],
          [
            'name'     => $row[6],
            'taxid'     => $row[7],
            'code'     => $row[0],
            'kingdom_id'     =>  Kingdom::where('kingdom',$row[1])->first()->id ?? NULL,
            'clade_id'     =>  Clade::where('clade',$row[2])->first()->id ?? NULL,
            'supergroup_id' => Supergroup::where('supergroup',$row[3])->first()->id ?? NULL,
            'order_id'     =>  Order::where('order',$row[4])->first()->id ?? NULL,
            'family_id'     => Family::where('family',$row[5])->first()->id ?? NULL,

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

