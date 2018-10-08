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

/** TWEETS ********************************************************************/

Route::get( '/tweets/getTweets', 'TweetsController@get' )->name( 'getTweets' );
Route::get( '/tweets/getPosts', 'TweetsController@posts' )->name( 'getPosts' );

/** POINTS ********************************************************************/

// DEPRECATED:
Route::get( '/points/grabPoints', 'PointsController@grab' )->name( 'grabPoints' );

Route::prefix( 'points' )->group(
  function ()
  {
    Route::post( '/postPoints/', 'PointsController@post' )->name( 'postPoints' );
    Route::get( '/getPoints', 'PointsController@get' )->name( 'getPoints' );
  }
);

// DEPRECATED:
Route::get( '/points/grabTeams/{teams}', 'PointsController@grab_teams' )->name( 'grabTeams' );


Route::group(
  [
    'middleware' => 'auth:api'
  ],
  function ()
  {
    Route::delete( '/users/{id}', 'UserController@delete' )->name( 'deleteuser' );
  }
);

Route::middleware( 'auth:api' )->get(
  '/user',
  function ( Request $request )
  {
    return $request->user();
  }
);

/******************************************************************************/



/** BEGIN: LEADERBOARD ROUTES *************************************************/

Route::get( '/leaderboard', 'LeaderboardController@get' )->name( 'getLeaderboards' );
Route::get( '/leaderboard/screens', 'LeaderboardController@get_screens' )->name( 'getScreens' );

/** END: LEADERBOARD ROUTES ***************************************************/

/** BEGIN: SOCIAL WALL ROUTES *************************************************/
Route::group(
  [
    'namespace'  => 'SocialWall',
    'middleware' => []
  ],
  function ()
  {
    /** BEGIN: SCOREBOARD -------------------------------------------------- **/
    Route::get( '/scoreboard/get-team-scores', 'ScoreboardController@GetTeamScores' );
    Route::get( '/scoreboard/get-team-member-scores', 'ScoreboardController@GetAllTopTeamMembersScores' );
    Route::get( '/scoreboard/get-team-member-scores/{team_name}', 'ScoreboardController@GetTopTeamMembersScores' );
    /** END: SCOREBOARD ---------------------------------------------------- **/
    /** BEGIN: SOCIAL CARDS ------------------------------------------------ **/
    Route::get( '/social-cards/get-cards', 'SocialCardsController@GetCards' );
    /** END: SOCIAL CARDS -------------------------------------------------- **/

  }
);
/** END: SOCIAL WALL ROUTES ***************************************************/
