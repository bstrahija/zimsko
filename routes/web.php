<?php

use App\Http\Controllers\AchievementsController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TeamsController;
use App\LiveScore\Http\GamesController as LiveGamesController;
use App\LiveScore\Http\PlayersController as LivePlayersController;
use App\LiveScore\Http\ScoreController as LiveScoreController;
use Illuminate\Support\Facades\Route;

// Auth
Route::redirect('login', 'admin/login')->name('login');

// Pages
Route::get('/', [PagesController::class,   'index'])->name('home');
Route::get('kontakt', [PagesController::class,   'contact'])->name('contact');
Route::post('kontakt', [PagesController::class,   'contactSubmit'])->name('contact.submit');
Route::get('novosti', [PostsController::class,   'index'])->name('news');
Route::get('novosti/{slug}', [PostsController::class,   'show'])->name('news.show');
Route::get('rezultati', [GamesController::class,   'results'])->name('results');
Route::get('raspored', [GamesController::class,   'schedule'])->name('schedule');
Route::get('utakmice/{slug}', [GamesController::class,   'show'])->name('games.show');
Route::get('ekipe', [TeamsController::class,   'index'])->name('teams');
Route::get('ekipe/{slug}', [TeamsController::class,   'show'])->name('teams.show');
Route::get('igraci/{slug}', [PlayersController::class, 'show'])->name('players.show');
Route::get('statistika', [StatsController::class,   'index'])->name('stats');

// Merch/shop
Route::get('donacije', [ProductsController::class, 'index'])->name('products.index');
Route::get('donacije/potvrda/{order}', [ProductsController::class, 'order'])->name('products.order');
Route::get('donacije/{product}', [ProductsController::class, 'show'])->name('products.show');
Route::get('orders/export', [ProductsController::class, 'orders'])->name('orders.export')->middleware('auth');

// Reports
Route::get('izvestaji/utakmica/{slug}', [ReportsController::class, 'game'])->name('reports.game');

// Testing
Route::get('globetka', [PagesController::class, 'globetka'])->name('globetka');

// Manage live games
Route::get('live', [LiveGamesController::class, 'index'])->name('live.games.index')->middleware('auth');
Route::get('live/create', [LiveGamesController::class, 'create'])->name('live.games.create')->middleware('auth');
Route::get('live/{game}/edit', [LiveGamesController::class, 'edit'])->name('live.games.edit')->middleware('auth');
Route::put('live/{game}', [LiveGamesController::class, 'update'])->name('live.games.update')->middleware('auth');
Route::delete('live/{game}', [LiveGamesController::class, 'destroy'])->name('live.games.delete')->middleware('auth');

// Manage live game players
Route::get('live/{game}/players', [LivePlayersController::class, 'index'])->name('live.players.index')->middleware('auth');
Route::put('live/{game}/players', [LivePlayersController::class, 'update'])->name('live.players.update')->middleware('auth');
Route::get('live/{game}/starting-players', [LivePlayersController::class, 'startingIndex'])->name('live.players.starting.index')->middleware('auth');
Route::put('live/{game}/starting-players', [LivePlayersController::class, 'startingUpdate'])->name('live.players.starting.update')->middleware('auth');
Route::get('live/{game}/players-on-court', [LivePlayersController::class, 'onCourtIndex'])->name('live.players.on_court.index')->middleware('auth');
Route::put('live/{game}/players-on-court', [LivePlayersController::class, 'onCourtUpdate'])->name('live.players.on_court.update')->middleware('auth');
Route::put('live/{game}/player-numbers', [LivePlayersController::class, 'updateNumbers'])->name('live.players.numbers.update')->middleware('auth');

// Manage live game stats
Route::get('live/{game}/score', [LiveScoreController::class, 'show'])->name('live.score.show')->middleware('auth');
Route::put('live/{game}/score', [LiveScoreController::class, 'update'])->name('live.score.update')->middleware('auth');
Route::put('live/{game}/start', [LiveScoreController::class, 'startGame'])->name('live.score.start')->middleware('auth');
Route::put('live/{game}/next-period', [LiveScoreController::class, 'nextPeriod'])->name('live.score.next_period')->middleware('auth');
Route::put('live/{game}/end', [LiveScoreController::class, 'endGame'])->name('live.score.end')->middleware('auth');
Route::post('live/{game}/reset-game', [LiveScoreController::class, 'resetGame'])->name('live.score.reset_game')->middleware('auth');
Route::delete('live/log/{log}', [LiveScoreController::class, 'deleteLogEntry'])->name('live.log.delete')->middleware('auth');
Route::post('live/generate-stats', [LiveScoreController::class, 'generateStats'])->name('live.generate_stats')->middleware('auth');

// Achievements
Route::get('achievements', [AchievementsController::class, 'index']);
