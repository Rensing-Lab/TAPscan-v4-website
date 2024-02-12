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
    Excel::import(new TapImport, $request->file('file'));return redirect()->route('taps.table')
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

  $tap2_count = DB::table('taps')
                ->select('tap_2', DB::raw('count(*) as num'))
                ->groupBy('tap_2');

  $tap_infos = DB::table('tap_infos')
  ->rightJoinSub($tap_count, 'tap_count', function ($join) {
      $join->on('tap_infos.tap', '=', 'tap_count.tap_1');
  })
  ->select('tap_1','num', 'type')
  ->orderBy('tap_1')
  ->get();

  $tap2_infos = DB::table('tap_infos')
  ->rightJoinSub($tap2_count, 'tap_count', function ($join) {
      $join->on('tap_infos.tap', '=', 'tap_count.tap_2');
  })
  ->select('tap_2','num', 'type')
  ->orderBy('tap_2')
  ->get();


  $subfamilies = DB::table('taps')
  ->select('tap_1', DB::raw('group_concat(distinct(tap_2)) as subfamilies'))
  ->groupBy('tap_1')
  ->orderBy('tap_1')
  ->get();


  return view('index', [
              'tap_count' => $tap_infos->keyBy('tap_1'),
              'tap2_count' => $tap2_infos->keyBy('tap_2'),
              'subfamilies' => $subfamilies->keyBy('tap_1'),
  ]);
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



public function subtap_show(string $id)
{
  return TapController::showtap($id,true);
}
public function tap_show( string $id)
{
  return TapController::showtap($id,false);
}
public function showtap(string $id, bool $isSubtap)
{
      $tap_rules = TapController::tap_rules($id);
      $tap_info = TapController::tap_info($id);

      if($isSubtap){
          $tap_distribution = TapController::subtap_distribution($id);
          $tap_species_number = TapController::subtap_species_number($id);
          $tap_count = DB::table('taps')
                ->select('tap_2')
                ->where('tap_2',$id)
                ->groupBy('tap_2')->count();
          $tap_show = DB::table('taps')
                  ->where('tap_2','=', $id)
                  ->get();
      }
      else{
          $tap_distribution = TapController::tap_distribution($id);
          $tap_species_number = TapController::tap_species_number($id);
          $tap_count = DB::table('taps')
                ->select('tap_1')
                ->where('tap_1',$id)
                ->groupBy('tap_1')->count();
          $tap_show = DB::table('taps')
                  ->where('tap_1','=', $id)
                  ->get();
                  // ->dump();
      }
      $tap_array = $tap_info[0]->reference ?? null;
      $domain_info = TapController::domain_info();

      return view('tap', ['tap_show' => $tap_show,
                          'tap_rules' => $tap_rules,
                          'id' => $id,
                          'tap_species_number' => $tap_species_number->count(),
                          'tap_distribution' => $tap_distribution,
		            	  'tap_info' => $tap_info,
			              'domain_info' => $domain_info,
                          'isSubtap'  => $isSubtap,
                          'tap_count' => $tap_count]);
}


public function tap_count_proteins($id)
{
  $tap_count = DB::table('taps')
                ->select('tap_1', '=', $id)
                ->count();


    return $tap_count;
}


public function dev()
{
  $tap_count = DB::table('taps')
                ->select('tap_1', DB::raw('count(*) as num'))
                ->groupBy('tap_1')->get()->toArray();
  $tap_count2 = DB::table('taps')
                ->select('tap_2', DB::raw('count(*) as num'))
                ->groupBy('tap_2')->get()->toArray();


  $db_taps = DB::table('taps')->get()->toArray();
  $db_tap_rules = DB::table('tap_rules')->get()->toArray();
  $db_domains = DB::table('domain')->get()->toArray();
  $db_species_tax_ids = DB::table('species_tax_ids')->get()->toArray();
  $db_tap_infos = DB::table('tap_infos')->get()->toArray();
  $db_sequences = DB::table('sequences')->get()->toArray();
  $treefiles = Storage::disk('public')->listContents('trees/');
  $fastafiles = Storage::disk('public')->listContents('fasta/');


  $db_tap_table_species = DB::table('taps')
     ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1) as species')
     ->distinct()
     ->get()
     ->toArray();

  return view('taps.dev', ['tap_count' => $tap_count,
                           'tap_count2' => $tap_count2,
                           'db_taps' => $db_taps,
                           'db_tap_rules' => $db_tap_rules,
                           'db_domains' => $db_domains,
                           'db_species_tax_ids' => $db_species_tax_ids,
                           'db_tap_infos' => $db_tap_infos,
                           'db_sequences' => $db_sequences,
                           'db_tap_table_species' => $db_tap_table_species,
                           'treefiles' => $treefiles,
                           'fastafiles' => $fastafiles,
   ]);

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

public function domain_info()
{
	$domain_info = DB::table('domain')
		->get();
  return $domain_info;
}

public function tap_species_number($id)
{
    $tap_species_number = DB::table('taps')
                ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1) as species')
                ->where('tap_1','=', $id)
                ->distinct()
                ->get();
    return $tap_species_number;
}

public function subtap_species_number($id)
{
    $tap_species_number = DB::table('taps')
                ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1) as species')
                ->where('tap_2','=', $id)
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
public function subtap_distribution($id)
{
  $tap_distribution = DB::table('taps')
              ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1)as name, COUNT(*) as test')
              ->where('tap_2','=', $id)
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

public function subtaptable(string $id): View
{
    return TapController::tapstable($id,true);

}
public function taptable(string $id): View
{
    return TapController::tapstable($id,false);
}


public function tapstable(string $id, bool $isSubtap): View
{
   if($isSubtap){
     $species_ids = TapController::subtap_species_number($id);
   }
   else{
     $species_ids = TapController::tap_species_number($id);
   }
   $species_array = array();
   foreach($species_ids as $s)
   {
     array_push($species_array,$s->{'species'});
   }
   $species_info = DB::table('species_tax_ids')
       ->whereIn('lettercode', $species_array)
       ->get();

   return view('taps.speciestable', [
   'species_ids' => $species_ids,
   'numspecies'  => $species_ids->count(),
   'id' => $id,
   'species_info' => $species_info,
   'isSubtap'    => $isSubtap,
   ]);
}




public function index()
{
  return view('taps.index');
}

public function initialization()
{
$download_buttons = ["species","rules","tap","tapinfo","domains"];

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

  $species_name = SpeciesTaxId::find($id)->lettercode;
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

  $species_name = SpeciesTaxId::find($species_id)->lettercode;
  $species_full_name = SpeciesTaxId::find($species_id)->name;
  $species_taxid = SpeciesTaxId::find($species_id)->taxid;
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
    $intersect2[$i]['plaza'] = [$species_taxid,ltrim(strstr($key,'_'),'_')];
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



// Same function but for subfamilies
public function show_species_sub($species_id, $tap_name, Request $request)
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

  $species_name = SpeciesTaxId::find($species_id)->lettercode;
  $species_full_name = SpeciesTaxId::find($species_id)->name;
  $species_taxid = SpeciesTaxId::find($species_id)->taxid;
  $fasta_path = '/public/fasta/' . $species_name . '.fa';
  $fasta = Storage::get($fasta_path);
  $test = fas_get($fasta);
  $test2 = collect($test);

  $test3 = SpeciesTaxId::find($species_id)->taps->where('tap_2', $tap_name);
  $items_name = $test3->pluck('tap_id')->flip();
  $intersect = $test2->intersectbyKeys($items_name);

  #dd(collect($child_arr));
  $test6 = [];

 $i = 0;
 foreach ($intersect as $key => $value){
  // $intersect->each(function ($item, $key) {
    $intersect2[]['id'] = $key;
    $intersect2[$i]['sequence'] = $value;
    $intersect2[$i]['plaza'] = [$species_taxid,ltrim(strstr($key,'_'),'_')];
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

  return view('taps.subtapspecies', ['species_id' => $species_id, 'tap_name' => $tap_name, 'species_full_name' => $species_full_name]);
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
