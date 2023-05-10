<?php

use App\Http\Controllers\SellBuyPlayerController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamPlayerController;
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
    return view('welcome');
});

Route::resource('team-player', TeamPlayerController::class);
Route::resource('teams', TeamController::class);
Route::resource('sell-buy-player', SellBuyPlayerController::class);
Route::post('sell-buy-player/{id}/sell', [SellBuyPlayerController::class, 'sell'])->name('sell-buy-player.sell');
Route::post('sell-buy-player/buy', [SellBuyPlayerController::class, 'buy'])->name('sell-buy-player.buy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
