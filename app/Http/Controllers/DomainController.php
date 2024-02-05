<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use \Illuminate\View\View;
use App\Tables\DomainTable;
use App\Tables\DomainTableSimple;
use App\Imports\DomainImport;
use Illuminate\Support\Facades\Storage;
use App\Models\SpeciesTaxId;
use App\Models\TapRules;
use App\Models\Domain;
use Spatie\Searchable\Search;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class DomainController extends Controller
{

  public function import(Request $request)
{
    Excel::import(new DomainImport(), $request->file('file'));return redirect()->route('domain.table')
        ->with('success', 'Products has been imported');
}


public function table(): View
{
    $table = (new DomainTable())->setup();

    return view('domain.table', compact('table'));
}

public function index()
{
    $table = (new DomainTableSimple())->setup();
    #$domain_list =  DB::table('domain')->get();
    #return view('domain.index', ['domains' => $domain_list]);
    return view('domain.index', compact('table'));
}

}
