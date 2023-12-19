<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TapExport;
use App\Imports\TapImport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use \Illuminate\View\View;
use \App\Tables\TapTable;
use Illuminate\Support\Facades\Storage;
use App\Models\SpeciesTaxId;
use App\Models\TapRules;
use App\Models\Tap;
use Spatie\Searchable\Search;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class TapController extends Controller
{

  public function import(Request $request)
{
    set_time_limit(300);
    Excel::import(new TapImport, $request->file('file'));return redirect()->route('tap.index')
        ->with('success', 'Products has been imported');
}
  public function export()
{
    return Excel::download(new TapExport(), 'products.xlsx');
}

  public function tap_count()
{
  $tap_count = DB::table('taps')
                ->select('tap_1', DB::raw('count(*) as num'))
                ->groupBy('tap_1');

  $tap_infos = DB::table('tap_infos')
  ->rightJoinSub($tap_count, 'tap_count', function ($join) {
      $join->on('tap_infos.tap', '=', 'tap_count.tap_1');
  })
  ->select('tap_1','num', 'type')
  ->orderBy('tap_1')
  ->get();


    return view('index', ['tap_count' => $tap_infos]);
}

public function circle_viz()
{
$circle_viz = DB::table('taps')
              ->selectRaw('tap_1,count(*) as num')
              ->groupBy('tap_1')
              ->get();

              // ->dump();
  return view('visualization.index', ['circle_viz' => $circle_viz]);
}

  public function tap_show($id)
{
      $tap_rules = TapController::tap_rules($id);
      $tap_species_number = TapController::tap_species_number($id);
      $tap_distribution = TapController::tap_distribution($id);
      $tap_info = TapController::tap_info($id);
      $tap_count = TapController::tap_count_proteins($id);
      $tap_array = $tap_info[0]->reference;

      $tap_show = DB::table('taps')
                  ->where('tap_1','=', $id)
                  ->get();
                  // ->dump();
      return view('tap', ['tap_show' => $tap_show,
                          'tap_rules' => $tap_rules,
                          'id' => $id,
                          'tap_species_number' => $tap_species_number->count(),
                          'tap_distribution' => $tap_distribution,
                          'tap_info' => $tap_info,
                          'tap_count' => $tap_count]);
}

public function tap_count_proteins($id)
{
  $tap_count = DB::table('taps')
                ->select('tap_1', '=', $id)
                ->count();


    return $tap_count;
}

public function tap_rules($id)
{
  $tap_rules = DB::table('tap_rules')
                  ->where('tap_1', '=', $id)
                  ->orderBy('rule','asc')
                  ->get();
      return $tap_rules;
}

public function tap_info($id)
{
  $tap_info = DB::table('tap_infos')->where('tap', '=', $id)->get();
      return $tap_info;
}

public function tap_species_number($id)
{
    $tap_species_number = DB::table('taps')
                ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1)')
                ->where('tap_1','=', $id)
                ->distinct()
                ->get();
    return $tap_species_number;
}

public function tap_distribution($id)
{
  $tap_distribution = DB::table('taps')
              ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1)as name, COUNT(*) as test')
              ->where('tap_1','=', $id)
              ->groupBy('name')
              ->orderBy('test')
              ->get();
  return $tap_distribution;
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

public function initialization()
{
$download_buttons = ["species","rules","tap","tapinfo"];

return view('taps.data-upload', ["download_buttons" => $download_buttons]);
}

public function show($id, Request $request)
{

#https://www.biob.in/2017/09/extracting-multiple-fasta-sequences.html
function get_seq($x) { // Get Sequence and Sequence Name
 $fl = explode(PHP_EOL, $x);
 $sh1 = trim(array_shift($fl));
 $sh2 = explode(" ", $sh1);
 $sh = $sh2[0];
 if($sh == null) {
  $sh = "UNKNOWN SEQUENCE";
 }
 $fl = array_filter($fl);
 $seq = "";
 foreach($fl as $str) {
  $seq .= trim($str);
 }
 $seq = strtoupper($seq);
 $seq = preg_replace("/[^ACDEFGHIKLMNPQRSTVWY]/i", "", $seq);
 if ((count($fl) < 1) || (strlen($seq) == 0)) {
  #print "Sequence is Empty!!";
  #exit();
  return array($sh, $seq);
 } else {
  return array($sh, $seq);
 }
}

function fas_get($x) { // Read Multiple FASTA Sequences
 $gtr = substr($x, 1);
 $sqs = explode(">", $gtr);
 if (count($sqs) > 1) {
  foreach ($sqs as $sq) {
   $spair = get_seq($sq);
   $spairs[$spair[0]] = $spair[1];
   // $spairs['id'][] = $spair[0];
   // $spairs['sequence'][] = $spair[1];
  }
  return $spairs;
 } else {
  $spair = get_seq($gtr);
  return array($spair[0] => $spair[1]);
 }
}

  $species_name = SpeciesTaxId::find($id)->code;
  $fasta_path = '/public/fasta/' . $species_name . '.fa';
  $fasta = Storage::get($fasta_path);
  $test = fas_get($fasta);
  $test2 = collect($test);

  $test3 = SpeciesTaxId::find($id)->taps;
  $items_name = $test3->pluck('tap_id')->flip();
  $intersect = $test2->intersectbyKeys($items_name);
  #dd(collect($child_arr));
  $test6 = [];

 $i = 0;
 foreach ($intersect as $key => $value){
  // $intersect->each(function ($item, $key) {
    $intersect2[]['id'] = $key;
    $intersect2[$i]['sequence'] = $value;
    $i++;
  };


      if ($request->ajax($id)) {
        return DataTables::of($intersect2)
          // return Datatables::of($intersect)
                  ->addIndexColumn()
                  // ->addColumn('action', function($row){
                  //
                  //        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                  //
                  //         return $btn;
                  // })
                  // ->rawColumns(['action'])
                  ->make(true);
      };

  return view('news.index', ['tap' => $id]);
}

public function show_species($species_id, $tap_name, Request $request)
{

#https://www.biob.in/2017/09/extracting-multiple-fasta-sequences.html
function get_seq($x) { // Get Sequence and Sequence Name
 $fl = explode(PHP_EOL, $x);
 $sh1 = trim(array_shift($fl));
 $sh2 = explode(" ", $sh1);
 $sh = $sh2[0];
 if($sh == null) {
  $sh = "UNKNOWN SEQUENCE";
 }
 $fl = array_filter($fl);
 $seq = "";
 foreach($fl as $str) {
  $seq .= trim($str);
 }
 $seq = strtoupper($seq);
 $seq = preg_replace("/[^ACDEFGHIKLMNPQRSTVWY]/i", "", $seq);
 if ((count($fl) < 1) || (strlen($seq) == 0)) {
  #print "Sequence is Empty!!";
  #exit();
  return array($sh, $seq);
 } else {
  return array($sh, $seq);
 }
}

function fas_get($x) { // Read Multiple FASTA Sequences
 $gtr = substr($x, 1);
 $sqs = explode(">", $gtr);
 if (count($sqs) > 1) {
  foreach ($sqs as $sq) {
   $spair = get_seq($sq);
   $spairs[$spair[0]] = $spair[1];
   // $spairs['id'][] = $spair[0];
   // $spairs['sequence'][] = $spair[1];
  }
  return $spairs;
 } else {
  $spair = get_seq($gtr);
  return array($spair[0] => $spair[1]);
 }
}

  $species_name = SpeciesTaxId::find($species_id)->code;
  $species_full_name = SpeciesTaxId::find($species_id)->name;
  $fasta_path = '/public/fasta/' . $species_name . '.fa';
  $fasta = Storage::get($fasta_path);
  $test = fas_get($fasta);
  $test2 = collect($test);

  $test3 = SpeciesTaxId::find($species_id)->taps->where('tap_1', $tap_name);
  $items_name = $test3->pluck('tap_id')->flip();
  $intersect = $test2->intersectbyKeys($items_name);
  
  #dd(collect($child_arr));
  $test6 = [];

 $i = 0;
 foreach ($intersect as $key => $value){
  // $intersect->each(function ($item, $key) {
    $intersect2[]['id'] = $key;
    $intersect2[$i]['sequence'] = $value;
    $intersect2[$i]['tap_1'] = Tap::where('tap_id', $key)->select('tap_1')->first()->tap_1;
    $intersect2[$i]['tap_2'] = Tap::where('tap_id', $key)->select('tap_2')->first()->tap_2;
    $i++;
  };
  // dd($intersect2);

      if ($request->ajax($species_id)) {
        return DataTables::of($intersect2)
          // return Datatables::of($intersect)
                  ->addIndexColumn()
                  // ->addColumn('action', function($row){
                  //
                  //        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                  //
                  //         return $btn;
                  // })
                  // ->rawColumns(['action'])
                  ->make(true);
      };

  return view('taps.species', ['species_id' => $species_id, 'tap_name' => $tap_name, 'species_full_name' => $species_full_name]);
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

public function search(Request $request)
{
   $searchResults = (new Search())
        ->registerModel(SpeciesTaxId::class, 'name')
        ->registerModel(TapRules::class, 'tap_1')
        ->perform($request->input('query'));

    return view('search.index', compact('searchResults'));
}
}
