<?php

namespace App\Exports;

use App\Models\SpeciesTaxId;
use Maatwebsite\Excel\Concerns\FromCollection;

class SpeciesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SpeciesTaxId::all();
    }
}
