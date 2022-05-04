<?php

namespace App\Exports;

use App\Models\Tap;
use Maatwebsite\Excel\Concerns\FromCollection;

class TapExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Tap::all();
    }
}
