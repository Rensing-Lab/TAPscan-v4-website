<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TapExport;
use App\Imports\TapInfoImport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use \Illuminate\View\View;
use \App\Tables\TapTable;
use Illuminate\Support\Facades\Storage;
use App\Models\SpeciesTaxId;
use App\Models\TapRules;
use Spatie\Searchable\Search;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class TapInfoController extends Controller
{

  public function import(Request $request)
{
    Excel::import(new TapInfoImport(), $request->file('file'));return redirect()->route('tap.index')
        ->with('success', 'Products has been imported');
}


public function table(): View
{
    $table = (new TapTable())->setup();

    return view('taps.table', compact('table'));
}

public function index()
{
  return view('taps.index');
}





}
