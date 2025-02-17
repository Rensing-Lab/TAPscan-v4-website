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
      $rows->shift(); # skip header line

      foreach ($rows as $row)
      {

        //$lettercode = trim($row[0],'abcdefghijklmnopqrstuvwxyz'); // only the initial uppercase part
        //$lettercode = preg_split('/(?=[a-z])/',$row[0])[0];
        $lettercode = $row[0];
        $name = $row[6];
        $taxid = $row[7];

        // taxonomy, handle missing data '-' in a way that doesnt break our tree
        $kingdom = $row[1];
        $clade = $row[2];
        #if($clade == '-'){
        #  $clade='_'.$clade.'_'.$kingdom;
        #}
        $supergroup = $row[3];
        #if($supergroup == '-'){
          #$supergroup='_'.$supergroup.'_'.$clade.'_'.$kingdom;
          #$supergroup='none';
        #}
        $order = $row[4];
        #if($order == '-'){
        #  $order='_'.$order.'_'.$supergroup.'_'.$clade.'_'.$kingdom;
        #}
        $family = $row[5];
        #if($family == '-'){
        #  $family='_'.$family.'_'.$order.'_'.$supergroup.'_'.$clade.'_'.$kingdom;
        #}


        Kingdom::updateOrCreate(
          [
            'kingdom'    => $kingdom,
          ],
          [
            'kingdom'     => $kingdom,
          ]
        );

        $kingdom_taxonomy=$kingdom;
        $clade_taxonomy=$kingdom.'|'.$clade;
        Clade::updateOrCreate(
          [
            'ancestry'    => $clade_taxonomy,
          ],
          [
            'ancestry'    => $clade_taxonomy,
            'clade'     => $clade,
            'kingdom_id'     =>  Kingdom::where('kingdom',$kingdom_taxonomy)->first()->id ?? NULL,
          ]
        );

        $supergroup_taxonomy=$clade_taxonomy.'|'.$supergroup;
        Supergroup::updateOrCreate(
          [
            'ancestry'    => $supergroup_taxonomy,
          ],
          [
            'ancestry'    => $supergroup_taxonomy,
            'supergroup'     => $supergroup,
            'clade_id'     =>  Clade::where('ancestry',$clade_taxonomy)->first()->id ?? NULL,
          ]
        );

        $order_taxonomy=$supergroup_taxonomy.'|'.$order;
        Order::updateOrCreate(
          [
            'ancestry'    => $order_taxonomy,
          ],
          [
            'ancestry'    => $order_taxonomy,
            'order'     => $order,
            'supergroup_id' => Supergroup::where('ancestry',$supergroup_taxonomy)->first()->id ?? NULL,
          ]
        );

        $family_taxonomy=$order_taxonomy.'|'.$family;
        Family::updateOrCreate(
          [
            'ancestry'    => $family_taxonomy,
          ],
          [
            'ancestry'    => $family_taxonomy,
            'family'     => $family,
            'order_id'     =>  Order::where('ancestry',$order_taxonomy)->first()->id ?? NULL,
          ]
        );

        $species_taxonomy=$family_taxonomy.'|'.$name.'|'.$lettercode;
        SpeciesTaxId::updateOrCreate(
          [
            'ancestry'      => $species_taxonomy,
          ],
          [
            'name'     => $name,
            'taxid'     => $taxid,
            'lettercode'     => $lettercode,
            'kingdom_id'     =>  Kingdom::where('kingdom',$kingdom)->first()->id ?? NULL,
            'clade_id'     =>  Clade::where('ancestry',$clade_taxonomy)->first()->id ?? NULL,
            'supergroup_id' => Supergroup::where('ancestry',$supergroup_taxonomy)->first()->id ?? NULL,
            'order_id'     =>  Order::where('ancestry',$order_taxonomy)->first()->id ?? NULL,
            'family_id'     => Family::where('ancestry',$family_taxonomy)->first()->id ?? NULL,
            'ancestry'    => $species_taxonomy,
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

