<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SpeciesExport;
use App\Imports\SpeciesImport;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use App\Tables\SpeciesTable;
use App\Models\SpeciesTaxId;

class SpeciesController extends Controller
{

  public function import(Request $request)
{
    Excel::import(new SpeciesImport(), $request->file('file'));return redirect()->route('tap.index')
        ->with('success', 'Products has been imported');
}public function export()
{
    return Excel::download(new SpeciesExport(), 'products.xlsx');
}

public function index(): View
{
    $table = (new SpeciesTable())->setup();

    return view('speciestaxids.index', compact('table'));
}

public function edit()
{}

    //
}
