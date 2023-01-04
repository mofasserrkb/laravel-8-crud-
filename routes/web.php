<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\poscontroller;
use App\Http\Controllers\ProductController;

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
//     return view('products.index');
// });

//Route::get('/pos',[poscontroller::class,'store'])->name('store');
Route::post('/pos',[poscontroller::class,'store'])->name('pos.store');
Route::get('item_price', [poscontroller::class,'itemPrice'])->name('pos.item_price');
Route::get('/products/create',[ProductController::class,'create'])->name('products.create');
Route::post('/products',[ProductController::class,'store'])->name('products.store');
Route::get('/',[ProductController::class,'index'])->name('products.index');
Route::get('/products/{prouduct}/edit',[ProductController::class,'edit'])->name('products.edit');
Route::get('/products/{prouduct}',[ProductController::class,'show'])->name('products.show');
Route::put('/products/{prouduct}',[ProductController::class,'update'])->name('products.update');
Route::delete('/products/{prouduct}',[ProductController::class,'destroy'])->name('products.destroy');
