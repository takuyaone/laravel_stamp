<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;

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
    Route::post('/break-start', [StampController::class, 'breakStart'])->name('break-start');
    Route::post('/break-end', [StampController::class, 'breakEnd'])->name('break-end');
    Route::get('/show', [StampController::class, 'showTable'])->name('show');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
