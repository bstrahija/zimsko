<?php

use App\Http\Controllers\GalleriesController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TeamsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'index'])->name('home');
Route::get('history', [PagesController::class, 'history'])->name('history');
Route::get('kontakt', [PagesController::class, 'contact'])->name('contact');
Route::post('kontakt', [PagesController::class, 'contactSubmit'])->name('contact.submit');
Route::redirect('login', 'admin/login')->name('login');

Route::get('novosti', [PostsController::class, 'index'])->name('news');
Route::get('novosti/{post}', [PostsController::class, 'show'])->name('news.show');
Route::get('rezultati', [GamesController::class, 'results'])->name('results');
Route::get('rezultati/{game}', [GamesController::class, 'show'])->name('results.show');
Route::get('raspored', [GamesController::class, 'schedule'])->name('schedule');
Route::get('ekipe', [TeamsController::class, 'index'])->name('teams');
Route::get('ekipe/{team}', [TeamsController::class, 'show'])->name('teams.show');
Route::get('igraci/{player}', [PlayersController::class, 'show'])->name('players.show');
Route::get('galerije', [GalleriesController::class, 'index'])->name('galleries');
Route::get('galerije/{gallery}', [GalleriesController::class, 'show'])->name('galleries.show');

/**
 * Concepts (delete later)
 */

// Route::get('/concept/001', function () { return view('concept.001'); });
Route::view('/concept/001', 'concept.001')->name('concept.001');
Route::view('/concept/002', 'concept.002')->name('concept.002');
Route::view('live/concept', 'live.concept')->name('live.concept')->middleware('auth');
Route::view('live/concept01', 'live.concept01')->name('live.concept1')->middleware('auth');

/**
 * Live score
 */

// Manage games
Route::get('live', [LiveController::class, 'index'])->name('live')->middleware('auth');
Route::get('live/sim', [LiveController::class, 'sim'])->name('live.sim')->middleware('auth');

// Create/Edit a game
Route::get('live/create',                   [LiveController::class, 'create'])->name('live.create')->middleware('auth');
Route::get('live/{game}',                   [LiveController::class, 'details'])->name('live.details')->middleware('auth');
Route::delete('live/{game}',                [LiveController::class, 'destroy'])->name('live.delete')->middleware('auth');
Route::post('live/{game}/details',          [LiveController::class, 'detailsStore'])->name('live.details.store')->middleware('auth');
Route::get('live/{game}/players',           [LiveController::class, 'players'])->name('live.players')->middleware('auth');
Route::post('live/{game}/players',          [LiveController::class, 'playersStore'])->name('live.players.store')->middleware('auth');
Route::get('live/{game}/players-starting',  [LiveController::class, 'playersStarting'])->name('live.players.starting')->middleware('auth');
Route::post('live/{game}/players-starting', [LiveController::class, 'playersStartingStore'])->name('live.players.starting.store')->middleware('auth');
Route::get('live/{game}/score',             [LiveController::class, 'score'])->name('live.game')->middleware('auth');

// Keep the score
Route::post('live/{game}/score',        [LiveController::class, 'addScore'])->name('live.score')->middleware('auth');
Route::post('live/{game}/miss',         [LiveController::class, 'addMiss'])->name('live.miss')->middleware('auth');
Route::post('live/{game}/foul',         [LiveController::class, 'addFoul'])->name('live.foul')->middleware('auth');
Route::post('live/{game}/rebound',      [LiveController::class, 'addRebound'])->name('live.rebound')->middleware('auth');
Route::post('live/{game}/steal',        [LiveController::class, 'addSteal'])->name('live.steal')->middleware('auth');
Route::post('live/{game}/block',        [LiveController::class, 'addBlock'])->name('live.block')->middleware('auth');
Route::post('live/{game}/turnover',     [LiveController::class, 'addTurnover'])->name('live.turnover')->middleware('auth');
Route::post('live/{game}/assist',       [LiveController::class, 'addAssist'])->name('live.assist')->middleware('auth');
Route::post('live/{game}/timeout',      [LiveController::class, 'addTimeout'])->name('live.timeout')->middleware('auth');
Route::post('live/{game}/substitution', [LiveController::class, 'substitution'])->name('live.substitution')->middleware('auth');
Route::post('live/{game}/start-game',   [LiveController::class, 'startGame'])->name('live.start-game')->middleware('auth');
Route::post('live/{game}/next-period',  [LiveController::class, 'nextPeriod'])->name('live.next-period')->middleware('auth');
Route::post('live/{game}/end-game',     [LiveController::class, 'endGame'])->name('live.end-game')->middleware('auth');
Route::delete('live/log/{log}',         [LiveController::class, 'deleteLog'])->name('live.log')->middleware('auth');
