<?php

use App\Http\Controllers\WaterTrappingController;
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

Route::get('/', [WaterTrappingController::class, 'index'])->name('water.index');
Route::post('/process-file', [WaterTrappingController::class, 'processFileWeb'])->name('water.process-file');
Route::post('/process-input', [WaterTrappingController::class, 'processInputWeb'])->name('water.process-input');

// API Routes
Route::prefix('api')->group(function () {
    Route::post('/process-file', [WaterTrappingController::class, 'processFile'])->name('api.water.process-file');
    Route::post('/process-input', [WaterTrappingController::class, 'processInput'])->name('api.water.process-input');
});