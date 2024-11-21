<?php

use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TeamsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('history', [PagesController::class, 'history'])->name('history');
Route::get('kontakt', [PagesController::class, 'contact'])->name('contact');

Route::get('novosti', [PostsController::class, 'index'])->name('news');
Route::get('rezultati', [GamesController::class, 'results'])->name('results');
Route::get('raspored', [GamesController::class, 'schedule'])->name('schedule');
Route::get('ekipe', [TeamsController::class, 'index'])->name('teams');
Route::get('ekipe/{team}', [TeamsController::class, 'show'])->name('teams.show');
Route::get('galerije', [GalleriesController::class, 'index'])->name('galleries');
Route::get('galerije/{gallery}', [GalleriesController::class, 'show'])->name('galleries.show');
