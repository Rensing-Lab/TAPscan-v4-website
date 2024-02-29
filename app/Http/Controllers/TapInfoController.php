<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Searchable\Search;
use Yajra\DataTables\Facades\DataTables;

use App\Models\TapInfo;
use App\Imports\TapInfoImport;
use App\Tables\TapInfoTable;
use App\Tables\TapInfoTableSimple;

class TapInfoController extends Controller
{

  public function import(Request $request)
  {
    Excel::import(new TapInfoImport(), $request->file('file'));return redirect()->route('tapinfo.table')
        ->with('success', 'Products has been imported');
  }


  public function table(): View
  {
    $table = (new TapInfoTable())->setup();

    return view('tapinfo.table', compact('table'));
  }

  public function index()
  {
    $table = (new TapInfoTableSimple())->setup();
    return view('tapinfo.index',compact('table'));
  }

  public function edit(TapInfo $new,  $id)
  {
    $tapinfo_data = TapInfo::findOrFail($id);
    return view('tapinfo.edit', compact('tapinfo_data'));
  }

  public function update(Request $request, TapInfo $new, $id)
  {
       // validate
       // read more on validation at http://laravel.com/docs/validation
       $request->validate([
           'tap'       => 'required',
           'type'      => 'required',
           'text'      => 'required',
           'reference'  => 'required',
       ]);

       $tapinfo_data = TapInfo::find($id);

       $tapinfo_data->tap = $request->tap;
       $tapinfo_data->text = $request->text;
       $tapinfo_data->reference = $request->reference;
       $tapinfo_data->type = $request->type;

       // store
       $tapinfo_data->save();

       return redirect()->route('tapinfo.table')
         ->with('success', 'TAP Info updated successfully');
  }

  public function create()
  {
    return view('tapinfo.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'tap' => 'required',
      'text' => 'required',
      'reference' => 'required',
      'type' => 'required',
    ]);

    TapInfo::create($request->all());

    return redirect()->route('tapinfo.table')
    ->with('success', 'TapInfo created successfully.');
  }

  public function destroy(TapInfo $newss, $id)
  {
    $tapinfo_data = $newss::find($id);
    $tapinfo_data->delete();

    return redirect()->route('tapinfo.table')
      ->with('success', 'TAP info deleted successfully');
   }

}
