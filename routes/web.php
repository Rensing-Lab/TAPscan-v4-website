<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\TapRulesController;
use App\Http\Controllers\TapController;
use App\Http\Controllers\NewsController;

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

Route::get('/', [TapController::class, 'tap_count'])->name('tap.index');
Route::get('/visualization', [TapController::class, 'circle_viz']);
Route::get('/about', function () {
  return view('about.index');
});
Route::get('/contact', function () {
  return view('contact.index');
});
// Route::get('/search', function () {
//   return view('search.index');
// });

Route::get('/search', [TapController::class, 'search'])->name('search');



// Route::get('/index', function() {
// })->name('tap.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('species/import', [SpeciesController::class, 'import'])->middleware(['auth'])->name('species.import');
Route::get('species/export', [SpeciesController::class, 'export'])->middleware(['auth'])->name('species.export');

Route::post('rules/import', [TapRulesController::class, 'import'])->middleware(['auth'])->name('rules.import');
Route::get('rules/export', [TapRulesController::class, 'export'])->middleware(['auth'])->name('rules.export');

Route::post('tap/import', [TapController::class, 'import'])->middleware(['auth'])->name('tap.import');
Route::get('tap/export', [TapController::class, 'export'])->middleware(['auth'])->name('tap.export');

Route::get('/tap/{id}', [TapController::class, 'tap_show'])->where('id', '.*'); // ab damit in den resource controller

Route::get('/news/table', [NewsController::class, 'table'])->middleware(['auth']);
Route::get('/species/table', [SpeciesController::class, 'table'])->middleware(['auth']);
Route::get('/taps/table', [TapController::class, 'table'])->middleware(['auth']);
Route::get('/rules/table', [TapRulesController::class, 'table'])->middleware(['auth']);
// Route::get('/rules', [TapRulesController::class, 'index'])->middleware(['auth'])->name('rulestable.index'); //auch beides in ressource
// Route::get('/taps', [TapController::class, 'index'])->middleware(['auth'])->name('taptable.index'); // dies auch

Route::get('/ajax-autocomplete-search', [TapController::class, 'selectSearch']);

// Route::resource('datatable/species', [SpeciesController::class, 'datatable']);
Route::resource('species', SpeciesController::class);
Route::resource('rules', TapRulesController::class);
Route::resource('taps', TapController::class);
Route::resource('news', NewsController::class);

// Route::get('/species', [SpeciesController::class, 'index'])->middleware(['auth'])->name('speciestaxids.index');
// Route::get('/species/{id}/edit', [SpeciesController::class, 'edit'])->middleware(['auth'])->name('speciestaxid.edit');
// Route::get('/species/{id}/show', [SpeciesController::class, 'show'])->middleware(['auth'])->name('speciestaxid.show');




require __DIR__.'/auth.php';

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
