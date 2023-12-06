<?php

namespace App\Http\Controllers;

use App\Models\SpeciesTaxId;
use App\Models\Kingdom;
use App\Models\Clade;
use App\Models\Supergroup;
use App\Models\Order;
use App\Models\Family;
use Illuminate\Http\Request;
use \Illuminate\View\View;
use \App\Tables\SpeciesTable;
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
       $species_kingdom = Kingdom::all();
       $species_clade = Clade::all();
       $species_supergroup = Supergroup::all();
       $species_order = Order::all();
       $species_family = Family::all();

// create loop to get every kingdom,order,family and write stuff
       $data2 = [];

       foreach ($species_kingdom as $kingdom)
        $data2[] = [
              'id' => $kingdom->kingdom,
              'parent' => '#',
              'text' => $kingdom->kingdom,
        ];

        foreach ($species_clade as $clade)
         $data2[] = [
               'id' => $clade->clade,
               'parent' => $clade->kingdom()->value('kingdom'),
               'text' => $clade->clade,
         ];

         foreach ($species_supergroup as $supergroup)
          $data2[] = [
                'id' => $supergroup->supergroup,
                'parent' => $supergroup->clade()->value('clade'),
                'text' => $supergroup->supergroup,
          ];

          foreach ($species_order as $order)
           $data2[] = [
                 'id' => $order->order,
                 'parent' => $order->supergroup()->value('supergroup'),
                 'text' => $order->order,
           ];

           foreach ($species_family as $family)
            $data2[] = [
                  'id' => $family->family,
                  'parent' => $family->order()->value('order'),
                  'text' => $family->family,
            ];

         foreach ($species_tree as $species)
          $data2[] = [
                'id' => $species->id,
                'parent' => $species->family()->value('family'),
                'text' => $species->name
          ];

       return view('speciestaxids.index', ['species_tree'=>json_encode($data2)]);
     }

     public function table(): View
     {
         $table = (new SpeciesTable())->setup();

         return view('speciestaxids.table', compact('table'));
     }

     public function import(Request $request)
   {
       Excel::import(new SpeciesImport(), $request->file('file'));return redirect()->route('tap.index')
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
      $tap_count = SpeciesTaxId::find($specie)->taps->countBy('tap_1');
      return view('speciestaxids.show', ['tap_count' => $tap_count, 'species' => $species, 'id' => $specie]);
        //
    }

    public function show_tap(SpeciesTaxId $speciesTaxId, $specie, $tap_name)
    {
      $species = $speciesTaxId::findOrFail($specie);
      $tap_count = SpeciesTaxId::find($specie)->taps->countBy('tap_1');
      return view('speciestaxids.show_tap', ['tap_count' => $tap_count, 'species' => $species, 'specie' => $specie]);
        //
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

        return redirect()->route('species.index')
          ->with('success', 'Product updated successfully');
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
    $this->middleware('auth')->except(['index','show']);
}
}
