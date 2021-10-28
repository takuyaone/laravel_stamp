<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\ShowTableController;


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
//     return view('auth.login');
// });
Route::middleware('auth:users')->group(function () {
    Route::get('/', [StampController::class, 'index'])->name('index');
    Route::post('/start-work', [StampController::class, 'startWork'])->name('start-work');
    Route::post('/end-work', [StampController::class, 'endWork'])->name('end-work');
    Route::post('/rest-start', [StampController::class, 'restStart'])->name('rest-start');
    Route::post('/rest-end', [StampController::class, 'restEnd'])->name('rest-end');
    Route::get('/show', [ShowTableController::class, 'showTable'])->name('show');
    Route::post('/search', [ShowTableController::class, 'search'])->name('search');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
