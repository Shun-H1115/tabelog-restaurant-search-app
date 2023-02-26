<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GoodTagController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;

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

Route::get('/', [ShopController::class, 'index']);

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/top', [App\Http\Controllers\HomeController::class, 'top'])->name('top');

Route::post('reviews/store', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');
Route::get('reviews/get/create', [ReviewController::class, 'create'])->name('reviews.create.get')->middleware('auth');
Route::post('reviews/create', [ReviewController::class, 'create'])->name('reviews.create')->middleware('auth');
Route::resource('reviews', ReviewController::class)->only(['show', 'update', 'destroy'])->middleware('auth');


Route::resource('shops', ShopController::class)->only(['index', 'store'])->middleware('auth');
Route::get('reviews/get/{shop_id}', [ShopController::class, 'show_v2'])->name('reviews.show.get')->middleware('auth');
Route::post('reviews/{shop_id}', [ShopController::class, 'show'])->name('reviews.show')->middleware('auth');
Route::get('shops/ranking', [ShopController::class, 'ranking'])->name('shops.ranking')->middleware('auth');

Route::get('favorites', [FavoriteController::class, 'index'])->name('favorite.index')->middleware('auth');
Route::get('favorites/{shop_id}', [FavoriteController::class, 'store'])->name('favorite')->middleware('auth');
Route::get('unfavorites/{shop_id}', [FavoriteController::class, 'destroy'])->name('unfavorite')->middleware('auth');
Route::post('favorites/{shop_id}', [FavoriteController::class, 'store'])->name('favorite')->middleware('auth');
Route::post('unfavorites/{shop_id}', [FavoriteController::class, 'destroy'])->name('unfavorite')->middleware('auth');

Route::get('goodtag/{review_id}', [GoodTagController::class, 'goodtag'])->name('goodtag')->middleware('auth');
Route::get('ungoodtag/{review_id}', [GoodTagController::class, 'ungoodtag'])->name('ungoodtag')->middleware('auth');
Route::post('goodtag/{review_id}', [GoodTagController::class, 'goodtag'])->name('goodtag')->middleware('auth');
Route::post('ungoodtag/{review_id}', [GoodTagController::class, 'ungoodtag'])->name('ungoodtag')->middleware('auth');

Route::get('users/mypage', [UserController::class, 'mypage'])->name('mypage')->middleware('auth');
Route::get('users/mypage/edit', [UserController::class, 'edit'])->name('mypage.edit')->middleware('auth');
Route::post('users/mypage/edit', [UserController::class, 'edit'])->name('mypage.edit')->middleware('auth');
Route::put('users/mypage/edit', [UserController::class, 'edit'])->name('mypage.edit')->middleware('auth');
Route::put('users/mypage/update', [UserController::class, 'update'])->name('mypage.update')->middleware('auth');