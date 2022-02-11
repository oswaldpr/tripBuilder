<?php

use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [TripController::class, 'index']);
Route::post('/axiosRequest/addStopover', [TripController::class, 'addStopover']);
Route::post('/axiosRequest/removeStopover', [TripController::class, 'removeStopover']);

