<?php

use App\Livewire\ImportManager;
use App\Livewire\Kabupaten;
use App\Livewire\Provinsi;
use App\Livewire\Report;
use App\Livewire\Show;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/import');
});
Route::get('/provinsi', Provinsi::class)->name('provinsi');
Route::get('/kabupaten', Kabupaten::class)->name('kabupaten');
Route::get('/report', Report::class)->name('report');
Route::get('/import', ImportManager::class)->name('import');
