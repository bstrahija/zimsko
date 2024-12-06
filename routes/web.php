<?php

use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TeamsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('history', [PagesController::class, 'history'])->name('history');
Route::get('kontakt', [PagesController::class, 'contact'])->name('contact');
Route::redirect('login', 'admin/login')->name('login');

Route::get('novosti', [PostsController::class, 'index'])->name('news');
Route::get('novosti/{post}', [PostsController::class, 'show'])->name('news.show');
Route::get('rezultati', [GamesController::class, 'results'])->name('results');
Route::get('raspored', [GamesController::class, 'schedule'])->name('schedule');
Route::get('ekipe', [TeamsController::class, 'index'])->name('teams');
Route::get('ekipe/{team}', [TeamsController::class, 'show'])->name('teams.show');
Route::get('galerije', [GalleriesController::class, 'index'])->name('galleries');
Route::get('galerije/{gallery}', [GalleriesController::class, 'show'])->name('galleries.show');


Route::get('live', [LiveController::class, 'index'])->name('live')->middleware('auth');
Route::view('live/concept', 'live.concept')->name('live.concept')->middleware('auth');
Route::view('live/concept01', 'live.concept01')->name('live.concept')->middleware('auth');
Route::post('live/{game}/score', [LiveController::class, 'addScore'])->name('live.score')->middleware('auth');
Route::post('live/{game}/miss',  [LiveController::class, 'addMiss'])->name('live.miss')->middleware('auth');
Route::post('live/{game}/foul',  [LiveController::class, 'addFoul'])->name('live.miss')->middleware('auth');
Route::delete('live/log/{log}',  [LiveController::class, 'deleteLog'])->name('live.log')->middleware('auth');
