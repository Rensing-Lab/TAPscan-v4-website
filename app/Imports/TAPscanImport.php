<?php

namespace App\Imports;

use App\Models\Tap;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class TAPscanImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tap([
           'name'     => $row[0],
           'email'    => $row[1],
            //
        ]);
    }
}
