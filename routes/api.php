<?php

use Azuriom\Http\Controllers\Api\AuthController;
use Azuriom\Http\Controllers\Api\FeedController;
use Azuriom\Http\Controllers\Api\PostController;
use Azuriom\Http\Controllers\Api\ServerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('posts', PostController::class)->names('api.')->only(['index', 'show']);

Route::apiResource('servers', ServerController::class)->names('api.')->only('index');

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('/azlink')->middleware('server.token')->group(function () {
    Route::get('/', [ServerController::class, 'status'])->name('azlink');
    Route::post('/', [ServerController::class, 'fetch']);
    Route::post('/register', [ServerController::class, 'register']);
    Route::post('/email', [ServerController::class, 'updateEmail']);
});

Route::get('/rss', [FeedController::class, 'rss'])->name('feeds.rss');
Route::get('/atom', [FeedController::class, 'atom'])->name('feeds.atom');
