<?php
// all routes accessible by everybody
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

// all routes where we need to be signed in (token needed)
Route::group(['middleware' => ['jwt.auth']], function () {
  Route::get('logout', 'AuthController@logout');
  Route::get('me', 'AuthController@me');

  Route::post('game/create', 'GameController@create');
  Route::get('game/list', 'GameController@list');
  Route::get('game/waitlist', 'GameController@waitlist');
  Route::post('game/join', 'GameController@join');
  Route::post('game/play', 'GameController@play');
  Route::post('game/delete', 'GameController@delete');
  Route::get('deleteallgames', 'GameController@deleteAllGames');
});
