<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'index'])->name('home');

Route::get('rezultati', [GamesController::class, 'results'])->name('games.results');
Route::get('raspored', [GamesController::class, 'schedule'])->name('games.schedule');
Route::get('ekipe', [TeamsController::class, 'index'])->name('teams.index');
Route::get('ekipe/{team}', [TeamsController::class, 'show'])->name('teams.show');
Route::get('galerije', [GalleriesController::class, 'index'])->name('galleries.index');
Route::get('galerije/{gallery}', [GalleriesController::class, 'show'])->name('galleries.show');
