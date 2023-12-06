<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TapRulesExport;
use App\Imports\TapRulesImport;
use Illuminate\Support\Facades\Route;
use \Illuminate\View\View;
use \App\Tables\TapRulesTable;
use App\Models\TapRules;

class TapRulesController extends Controller
{

  public function import(Request $request)
{
    Excel::import(new TapRulesImport(), $request->file('file'));return redirect()->route('tap.index')
        ->with('success', 'Products has been imported');
}
public function export()
{
    return Excel::download(new TapRulesExport(), 'products.xlsx');
}


/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
 public function index(): View
 {
     $table = (new TapRulesTable())->setup();

     return view('rules.index', compact('table'));
 }

 public function table(): View
 {
     $table = (new TapRulesTable())->setup();

     return view('rules.table', compact('table'));
 }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    //
}

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
    //
}

/**
 * Display the specified resource.
 *
 * @param  \App\Models\TapRules  $tapRules
 * @return \Illuminate\Http\Response
 */

public function show(TapRules $tapRules, $rule)
{
  $rules = $tapRules::findOrFail($rule);
  return view('rules.show', compact('rules'));
    //
}

/**
 * Show the form for editing the specified resource.
 *
 * @param  \App\Models\TapRules  $tapRules
 * @return \Illuminate\Http\Response
 */
public function edit(TapRules $tapRules, $id)
{ //
  $rules = $tapRules::findOrFail($id);
  return view('rules.edit',compact('rules'));
}

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\TapRules  $tapRules
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, TapRules $tapRules, $id)
{        //

    // validate
    // read more on validation at http://laravel.com/docs/validation
    $request->validate([
        'tap_1'       => 'required',
        'rule'      => 'required|numeric'
    ]);

    $rules = TapRules::find($id);

    $rules->tap_1 = $request->tap_1;
    $rules->rule = $request->rule;

        // store
    $rules->save();

    return redirect()->route('species.index')
      ->with('success', 'Product updated successfully');
}

/**
 * Remove the specified resource from storage.
 *
 * @param  \App\Models\TapRules  $tapRules
 * @return \Illuminate\Http\Response
 */
public function destroy(TapRules $tapRules, $id)
{
  $rules = TapRules::find($id);
  $rules->delete();

  return redirect()->route('species.index')
    ->with('success', 'Product deleted successfully');
    //
}

public function __construct()
{
$this->middleware('auth')->except(['index','show']);
}
}
