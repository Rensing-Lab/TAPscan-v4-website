<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\TapRulesController;
use App\Http\Controllers\TapController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TapInfoController;
use App\Http\Controllers\DomainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('/', function () {
//     return view('welcome');
// });

# Main pages


Route::get('/species/{species_id}/tap/{tap_name}', [TapController::class, 'show_species'])->where('tap_name', '.*')->name('taps.species');
Route::get('/species/{species_id}/subtap/{tap_name}', [TapController::class, 'show_species_sub'])->where('tap_name', '.*')->name('taps.subtapspecies');
Route::get('/species-list', [SpeciesController::class, 'species_list'])->name('species.list');


# routes in this group will be cached. This speeds up the website for large amounts of data
Route::group(['middleware' => ['page-cache']], function () {
  Route::get('/', [TapController::class, 'tap_count'])->name('tap.index');
  Route::get('/families', [TapController::class, 'tap_count'])->name('tap.index');
  Route::get('/species/{specie}', [SpeciesController::class, 'show'])->where('specie', '.*')->name('speciestaxids.show');
  Route::get('/tap/{id}', [TapController::class, 'tap_show'])->where('id', '.*');
  Route::get('/subtap/{id}', [TapController::class, 'subtap_show'])->where('id', '.*');

  Route::get('/speciestable/tap/{id}', [TapController::class, 'taptable'])->where('id', '.*')->name('taps.speciestable');
  Route::get('/speciestable/subtap/{id}', [TapController::class, 'subtaptable'])->where('id', '.*')->name('taps.speciestable');
});


Route::get('/search', [TapController::class, 'search'])->name('search');
Route::get('/about', function () {
  return view('about.index');
});
Route::get('/data', [TapController::class, 'circle_viz'])->name('data.index');

# Admin tables
Route::get('/news/table', [NewsController::class, 'table'])->middleware(['auth'])->name('news.table');
Route::get('/species/table', [SpeciesController::class, 'table'])->middleware(['auth'])->name('species.table');
Route::get('/taps/table', [TapController::class, 'table'])->middleware(['auth'])->name('taps.table');
Route::get('/rules/table', [TapRulesController::class, 'table'])->middleware(['auth'])->name('rules.table');
Route::get('/tapinfo/table', [TapInfoController::class, 'table'])->middleware(['auth'])->name('tapinfo.table');
Route::get('/domain/table', [DomainController::class, 'table'])->middleware(['auth'])->name('domain.table');

# Admin Import/Export pages
Route::get('data-upload', [TapController::class, 'initialization'])->middleware(['auth'])->name('tap.data-upload');

Route::post('species/import', [SpeciesController::class, 'import'])->middleware(['auth'])->name('species.import');
Route::get('species/export', [SpeciesController::class, 'export'])->middleware(['auth'])->name('species.export');

Route::post('rules/import', [TapRulesController::class, 'import'])->middleware(['auth'])->name('rules.import');
Route::get('rules/export', [TapRulesController::class, 'export'])->middleware(['auth'])->name('rules.export');

Route::post('tap/import', [TapController::class, 'import'])->middleware(['auth'])->name('tap.import');
Route::get('tap/export', [TapController::class, 'export'])->middleware(['auth'])->name('tap.export');

Route::post('tapinfo/import', [TapInfoController::class, 'import'])->middleware(['auth'])->name('tapinfo.import');
Route::post('domains/import', [DomainController::class, 'import'])->middleware(['auth'])->name('domains.import');


# other defaults
Route::resource('species', SpeciesController::class);
Route::resource('taps', TapController::class);
Route::resource('tapinfo', TapInfoController::class);
Route::resource('news', NewsController::class);
Route::resource('rules', TapRulesController::class);
Route::resource('domain', DomainController::class);

# dev page
Route::get('/dev', [TapController::class, 'dev'])->name('taps.dev');


//Routes that were in this file but unclear if needed

//Route::get('/contact', function () {
//  return view('contact.index');
//});

//Route::get('/ajax-autocomplete-search', [TapController::class, 'selectSearch']);

//Route::get('/species/{species_id}/tap/{tap_name}', [SpeciesController::class, 'show_tap'])->name('speciestaxid.show_tap');

//Route::get('/visualization', [TapController::class, 'circle_viz']);
//Route::get('/contact', function () {
//  return view('contact.index');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
