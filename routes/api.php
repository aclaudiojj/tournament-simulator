<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('tournaments', '\\'.\Api\Http\Controllers\TournamentController::class);

Route::post('tournament/{id}/group', '\Api\Http\Controllers\TournamentController@addTeamToGroup');
Route::post('tournament/{id}/team', '\Api\Http\Controllers\TournamentController@addTeamToTournament');
Route::post('tournament/{id}/match', '\Api\Http\Controllers\TournamentController@addMatchReult');

Route::get('tournament/{id}/simulate', '\Api\Http\Controllers\TournamentController@simulate');