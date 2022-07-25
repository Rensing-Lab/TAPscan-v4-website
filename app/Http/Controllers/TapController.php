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
use Spatie\Searchable\Search;

class TapController extends Controller
{

  public function import(Request $request)
{
    Excel::import(new TapImport(), $request->file('file'));return redirect()->route('tap.index')
        ->with('success', 'Products has been imported');
}
  public function export()
{
    return Excel::download(new TapExport(), 'products.xlsx');
}

  public function tap_count()
{
  $tap_count = DB::table('taps')
                ->selectRaw('tap_1,count(*) as num')
                ->groupBy('tap_1')
                ->get();
  $download_buttons = ["tap","rules","species"];

                // ->dump();
    return view('index', ['tap_count' => $tap_count, "download_buttons" => $download_buttons]);
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
      // $tap_distribution_metrics = TapController::tap_distribution_metrics($tap_distribution);
      $tap_show = DB::table('taps')
                  ->where('tap_1','=', $id)
                  ->get();
                  // ->dump();
      return view('tap', ['tap_show' => $tap_show,
                          'tap_rules' => $tap_rules,
                          'id' => $id,
                          'tap_species_number' => $tap_species_number->count(),
                          'tap_distribution' => $tap_distribution]);
}

public function tap_rules($id)
{
  $tap_rules = DB::table('tap_rules')
                  ->where('tap_1', '=', $id)
                  ->orderBy('rule','asc')
                  ->get();
                  // ->dump();
      return $tap_rules;
}

public function tap_species_number($id)
{
    $tap_species_number = DB::table('taps')
                ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1)')
                ->where('tap_1','=', $id)
                ->distinct()
                ->get();
                // ->dump();
    return $tap_species_number;
}

public function tap_distribution($id)
{
  $tap_distribution = DB::table('taps')
              ->selectRaw('SUBSTRING_INDEX(tap_id, "_",  1)as name, COUNT(*) as test')
              ->where('tap_1','=', $id)
              ->groupBy('name')
              ->orderBy('test')
              // ->dump();
              // ->count();
              ->get();
              // ->dump();
  return $tap_distribution;
}

public function table(): View
{
    $table = (new TapTable())->setup();

    return view('taps.table', compact('table'));
}

public function index()
{


// function fas_check($x) { // Check FASTA File Format
//  $gt = substr($x, 0, 1);
//  if ($gt != ">") {
//   print "Not FASTA File!!";
//   exit();
//  } else {
//   return $x;
//  }
// }
#https://www.biob.in/2017/09/extracting-multiple-fasta-sequences.html
function get_seq($x) { // Get Sequence and Sequence Name
 $fl = explode(PHP_EOL, $x);
 $sh = trim(array_shift($fl));
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
  print "Sequence is Empty!!";
  exit();
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
  }
  return $spairs;
 } else {
  $spair = get_seq($gtr);
  return array($spair[0] => $spair[1]);
 }
}
  $fasta = Storage::get('/public/fasta/CAMSA.fa');
  $test = fas_get($fasta);
  dd($test);

  # hier muss eine Schleife hin die die fa. nach den IDs der TAP durchsucht und diese zurück gibt um damit eine Liste herzustellen.
  return view('taps.index', []);
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

// search in fasta  https://stackoverflow.com/questions/3686177/php-to-search-within-txt-file-and-echo-the-whole-line
// <?php
// $searchthis = "mystring";
// $matches = array();
//
// $handle = @fopen("path/to/inputfile.txt", "r");
// if ($handle)
// {
//     while (!feof($handle))
//     {
//         $buffer = fgets($handle);
//         if(strpos($buffer, $searchthis) !== FALSE)
//             $matches[] = $buffer;
//     }
//     fclose($handle);
// }
//
// //show results:
// print_r($matches);
//

    //
}
