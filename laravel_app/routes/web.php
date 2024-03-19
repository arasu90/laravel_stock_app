<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Portfolio;
use App\Http\Controllers\Watchlist;
use App\Http\Controllers\Allstock;
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

// Route::get('/', function () {
//     return view('dashboard');
// });

// Route::get('/','Dashboard@index');

Route::get('/', [Dashboard::class, 'index']);
Route::get('/dashboard/topgainer', [Dashboard::class, 'topgainer']);
Route::get('/dashboard/topgainerper', [Dashboard::class, 'topgainerPer']);
Route::get('/dashboard/toplooser', [Dashboard::class, 'topLooser']);
Route::get('/dashboard/toplooserper', [Dashboard::class, 'toplooserper']);
Route::get('/dashboard/highprice', [Dashboard::class, 'highestPrice']);
Route::get('/dashboard/lowprice', [Dashboard::class, 'lowestPrice']);
Route::get('/dashboard/yearlyhigh', [Dashboard::class, 'yearlyHigh']);
Route::get('/dashboard/yearlylow', [Dashboard::class, 'yearlyLow']);
Route::get('/myportfolio', [Portfolio::class, 'index']);
Route::post('/savePortfolio', [Portfolio::class, 'saveportfolio']);
Route::get('/deletePortfolio', [Portfolio::class, 'deletePortfolio']);
Route::get('/showallstock', [Allstock::class, 'index']);
Route::get('/stockData/{stock_symbol}', [Allstock::class, 'stockData']);
Route::get('/watchlist', [Watchlist::class, 'index']);
Route::get('/insertStockData', [Allstock::class, 'insertStockData']);
Route::get('/addwatchlist/{del_id}', [Watchlist::class, 'addwatchlist']);
// Route::post('/watchlist', [Watchlist::class, 'index']);



Route::get('/div',[UserController::class,'dummy']);


