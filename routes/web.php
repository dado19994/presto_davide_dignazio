<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AiListingCoachController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RevisorController;
use App\Http\Controllers\SellerProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'homepage'])->name('homepage');

Route::get('/create/article', [ArticleController::class, 'create'])->name('create.article')->middleware('auth');
Route::get('/article/index', [ArticleController::class, 'index'])->name('article.index');
Route::get('/annunci-in-evidenza', [ArticleController::class, 'featured'])->name('article.featured');
Route::get('/article/{article}/edit', [ArticleController::class, 'edit'])->middleware('auth')->name('article.edit');
Route::put('/article/{article}', [ArticleController::class, 'update'])->middleware('auth')->name('article.update');
Route::delete('/article/{article}', [ArticleController::class, 'destroy'])->middleware('auth')->name('article.destroy');
Route::patch('/article/{article}/republish', [ArticleController::class, 'republish'])->middleware('auth')->name('article.republish');
Route::patch('/article/{article}/highlight', [ArticleController::class, 'highlight'])->middleware('auth')->name('article.highlight');

Route::get('/show/article/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/category/{category}', [ArticleController::class, 'byCategory'])->name('byCategory');
Route::get('/venditore/{user}', [SellerProfileController::class, 'show'])->name('seller.show');

Route::get('/revisor/index', [RevisorController::class, 'index'])->middleware('isRevisor')->name('revisor.index');

Route::patch('/accept/{article}', [RevisorController::class, 'accept'])->name('revisor.accept');
Route::patch('/reject/{article}', [RevisorController::class, 'reject'])->name('revisor.reject');

Route::get('/revisor/request', [RevisorController::class, 'becomeRevisor'])->middleware('auth')->name('become.revisor');
Route::get('/make/revisor/{user}', [RevisorController::class, 'makeRevisor'])->name('make.revisor');

Route::get('/search/article', [PublicController::class, 'searchArticles'])->name('article.searched');

Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/termini', 'pages.terms')->name('terms');
Route::view('/sicurezza', 'pages.security')->name('security');

Route::get('/dashboard', [PublicController::class, 'dashboard'])->middleware('auth')->name('user.dashboard');
Route::get('/profilo', [ProfileController::class, 'edit'])->middleware('auth')->name('user.profile');
Route::patch('/profilo', [ProfileController::class, 'update'])->middleware('auth')->name('user.profile.update');
Route::get('/ai-listing-coach', [AiListingCoachController::class, 'index'])->middleware('auth')->name('ai.coach');

Route::get('/carrello', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrello/{article}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/carrello/{article}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/carrello', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/preferiti', [FavoriteController::class, 'index'])->middleware('auth')->name('favorites.index');
Route::post('/preferiti/{article}', [FavoriteController::class, 'toggle'])->middleware('auth')->name('favorites.toggle');

//cambio lingua
Route::post('/lingua/{lang}', [PublicController::class, 'setLanguage'])->name('setLocale');
