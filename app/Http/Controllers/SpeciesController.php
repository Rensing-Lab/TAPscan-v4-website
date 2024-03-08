<?php

namespace App\Http\Controllers;

use App\Models\SpeciesTaxId;
use App\Models\Kingdom;
use App\Models\Clade;
use App\Models\Supergroup;
use App\Models\Order;
use App\Models\Family;
use App\Models\Tap;
use App\Models\TapInfo;
use Illuminate\Http\Request;
use \Illuminate\View\View;
use \App\Tables\SpeciesTable;
use \App\Tables\SpeciesTableSimple;
use App\Http\Controllers\Input;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SpeciesExport;
use App\Imports\SpeciesImport;
use Illuminate\Support\Facades\DB;

class SpeciesController extends Controller
{

     public function index()
     {
       $species_tree = SpeciesTaxId::all();
       $species_kingdom = Kingdom::all()->keyBy('id');
       $species_clade = Clade::all()->keyBy('id');
       $species_supergroup = Supergroup::all()->keyBy('id');
       $species_order = Order::all()->keyBy('id');
       $species_family = Family::all()->keyBy('id');

       // create loop to get every kingdom,order,family and write output for jstree
       $data2 = [];

       foreach ($species_kingdom as $kingdom)
        $data2[] = [
              'id' => $kingdom->kingdom,
              'parent' => '#',
              'text' => ucfirst($kingdom->kingdom),
        ];

        foreach ($species_clade as $clade)
         $data2[] = [
               'id' => $clade->ancestry,
               'parent' => $species_kingdom[$clade->kingdom_id]->kingdom,
               'text' => ucfirst($clade->clade),
         ];

         foreach ($species_supergroup as $supergroup)
          $data2[] = [
                'id' => $supergroup->ancestry,
                'parent' => $species_clade[$supergroup->clade_id]->ancestry,
                'text' => ucfirst($supergroup->supergroup),
          ];

          foreach ($species_order as $order)
           $data2[] = [
                 'id' => $order->ancestry,
                 'parent' => $species_supergroup[$order->supergroup_id]->ancestry,
                 'text' => ucfirst($order->order),
           ];

           foreach ($species_family as $family)
            $data2[] = [
                  'id' => $family->ancestry,
                  'parent' => $species_order[$family->order_id]->ancestry,
                  'text' => ucfirst($family->family),
            ];

         foreach ($species_tree as $species)
          $data2[] = [
                'id' => $species->id,
                'parent' => $species_family[$species->family_id]->ancestry,
                'text' => $species->name.' ('.$species->lettercode.') &#128065;'
          ];

       return view('speciestaxids.index', [
                  'species_tree'=>json_encode($data2),
                  'species_array' =>$data2,
         ]);
     }

     public function table(): View
     {
         $table = (new SpeciesTable())->setup();

         return view('speciestaxids.table', compact('table'));
     }

     public function import(Request $request)
   {
       Excel::import(new SpeciesImport(), $request->file('file'));return redirect()->route('species.table')
           ->with('success', 'Products has been imported');
   }public function export()
   {
       return Excel::download(new SpeciesExport(), 'products.xlsx');
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
     * @param  \App\Models\SpeciesTaxId  $speciesTaxId
     * @return \Illuminate\Http\Response
     */

    public function show(SpeciesTaxId $speciesTaxId, $specie)
    {
      $species = $speciesTaxId::findOrFail($specie);
      $tap1 = $species->taps->sortBy('tap_1');
      $tap2 = $species->taps->sortBy('tap_2');

      $tap_count = $tap1->countBy('tap_1');
      $tap2_count = $tap2->countBy('tap_2');

      $species_subfamilies = $tap2->groupBy('tap_2');
      $species_families = $tap1->groupBy('tap_1');


      $tap_info = DB::table('tap_infos')
	          ->get();

      $subfamilies = DB::table('taps')
        ->select('tap_1', DB::raw('group_concat(distinct(tap_2)) as subfamilies'))
        ->groupBy('tap_1')
        ->orderBy('tap_1')
        ->get();

      $kingdom = Kingdom::where('id', $species->kingdom_id)->first()->kingdom;
      $clade = Clade::where('id', $species->clade_id)->first()->clade;
      $supergroup= Supergroup::where('id', $species->supergroup_id)->first()->supergroup;
      $order = Order::where('id', $species->order_id)->first()->order;
      $family = Family::where('id', $species->family_id)->first()->family;

      return view('speciestaxids.show', [
               'tap_count' => $tap_count,
               'tap2_count' => $tap2_count,
               'species' => $species,
               'id' => $specie,
               'species_families' => $species_families,
               'species_subfamilies' => $species_subfamilies,
               'subfamilies' => $subfamilies->keyBy('tap_1'),
               'tap_info' => $tap_info->keyBy('tap'),
               'kingdom' => $kingdom,
               'clade' => $clade,
               'supergroup' => $supergroup,
               'order' => $order,
               'family' => $family,

      ]);
    }

    public function show_tap(SpeciesTaxId $speciesTaxId, $specie, $tap_name)
    {
      $species = $speciesTaxId::findOrFail($specie);
      $tap_count = SpeciesTaxId::find($specie)->taps->countBy('tap_1');
      return view('speciestaxids.show_tap', ['tap_count' => $tap_count, 'species' => $species, 'specie' => $specie]);
        //
    }

    public function species_list()
    {
      $table = (new SpeciesTableSimple())->setup();
      return view('speciestaxids.list', compact('table'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SpeciesTaxId  $speciesTaxId
     * @return \Illuminate\Http\Response
     */
    public function edit(SpeciesTaxId $speciesTaxId, $id)
    { //
      $species = $speciesTaxId::findOrFail($id);
      return view('speciestaxids.edit',compact('species'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpeciesTaxId  $speciesTaxId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpeciesTaxId $speciesTaxId, $id)
    {        //

        // validate
        // read more on validation at http://laravel.com/docs/validation
        $request->validate([
            'name'       => 'required',
            'taxid'      => 'required|numeric'
        ]);

        $species = SpeciesTaxId::find($id);

        $species->name = $request->name;
        $species->taxid = $request->taxid;

        // store
        $species->save();

        return redirect()->route('species.table')
          ->with('success', 'Species updated successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpeciesTaxId  $speciesTaxId
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpeciesTaxId $speciesTaxId, $id)
    {
      $species = SpeciesTaxId::find($id);
      $species->delete();

      return redirect()->route('species.index')
        ->with('success', 'Product deleted successfully');
        //
    }

    public function __construct()
{
    $this->middleware('auth')->except(['index','show','species_list']);
}
}
