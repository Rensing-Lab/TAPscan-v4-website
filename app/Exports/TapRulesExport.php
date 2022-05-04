<?php

namespace App\Exports;

use App\Models\TapRules;
use Maatwebsite\Excel\Concerns\FromCollection;

class TapRulesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TapRules::all();
    }
}
