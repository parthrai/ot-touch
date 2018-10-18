<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
})->name('index');
 */

Route::redirect('/', 'https://opentext.com', 301);

Route::get('/socialwall/live', 'SocialwallController@live')->name('socialwall');
Route::get('/socialwall/react', 'SocialwallController@socialreact')->name('socialwall-react');
Route::get('/socialwall/debug', 'SocialwallController@debug')->name('_socialwall');
Route::get('/socialwall/twitter', 'SocialwallController@twitterwall')->name('twitterwall');
Route::post('/socialwall/refresh', 'SocialwallController@refresh')->name('socialwall.refresh');
Route::post('/socialwall/mrefresh', 'SocialwallController@mobileRefresh')->name('socialwall.mrefresh');
Route::get('socialwall/enable/{id}','SocialwallController@enableScreen')->name('socialwall.enable');
Route::get('socialwall/disable/{id}','SocialwallController@disableScreen')->name('socialwall.disable');
Route::get('socialwall/mobile', 'SocialwallController@mobileSocialwall')->name('socialwall.mobile');
Route::get('socialwall/countdown', 'SocialwallController@countdown')->name('socialwall.countdown');

Route::get('posts/storePosts', 'PostsController@storePosts')->name('posts.store');
Route::get('posts/getPosts', 'PostsController@index')->name('posts.index');
Route::get('posts/post/{id}', 'PostsController@get')->name('posts.get');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');
/** This route has been removed per instruction from Carolyn Bolger <cbolger@opentext.com>
 *
* Route::get('/itour', 'MobileApp@index')->name('mobileapp');
*
*/

Route::get('/ew18', 'MobileApp@index')->name('mobileapp');

Route::prefix('user')->group(function () {
// Controllers Within The "App\Http\Controllers\Users" Namespace

Route::get('/', 'UserController@index')->name('user')->middleware('auth');
Route::get('/create', 'UserController@create')->name('newuser')->middleware('auth');
Route::post('/create', 'UserController@create')->name('newuser')->middleware('auth');
Route::get('/token/create', 'UserController@createUserToken')->name('usertoken')->middleware('auth');
Route::get('/{id}/admin', 'UserController@giveUserAdminPermissions')->name('admin.create')->middleware('auth');
Route::get('/{id}/admin/destroy', 'UserController@removeUserAdminPermissions')->name('admin.remove')->middleware('auth');
Route::delete('/{id}', 'UserController@delete')->name('user.delete');
});


/*
Route::prefix('points')->group(function (){
Route::get('/', 'PointsController@index')->name('points')->middleware('auth');
Route::get('/getPoints', 'PointsController@get')->name('getPoints')->middleware('auth');
Route::post('/postPoints/', 'PointsController@post')->name('postPoints')->middleware('auth');
Route::delete('/{id}', 'PointsController@delete')->name('pointsdelete')->middleware('auth');
Route::post('/restore/{id}','PointsController@restore')->name('pointsRestore')->middleware('auth');
});

Route::post('/admin/clear/', 'PointsController@post')->name('admin.cache');
Route::post('/admin/refresh/', 'PointsController@post')->name('admin.refresh');
*/




Route::get('/points_app', 'PointsApp@index')->name('pointsapp.index');

Route::middleware('auth')->prefix('reports')->group(function(){
Route::get('/', 'Reports@index')->name('reports.index');
});














/** BEGIN: SCOREBOARD TEAM CONFIGS ADMIN ROUTES *******************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'scoreboardteamconfig'
  ],
  function ()
  {

    Route::get( '/', 'ScoreboardTeamConfigController@index' )->name( 'configure-teams' );

    Route::get( '/create', 'ScoreboardTeamConfigController@create_form' );
    Route::post( '/create', 'ScoreboardTeamConfigController@create' );

    Route::get( '/edit/{id}', 'ScoreboardTeamConfigController@edit' );
    Route::post( '/edit/{id}', 'ScoreboardTeamConfigController@update' );

    Route::get( '/delete/{id}', 'ScoreboardTeamConfigController@delete' );

    Route::get( '/reset-teams', 'ScoreboardTeamConfigController@reset_teams' )->name( 'scoreboardteamconfig.reset-teams' );

  }
);
/** END: SCOREBOARD TEAM CONFIGS ADMIN ROUTES *********************************/

/** BEGIN: POINTS ADMIN ROUTES ************************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'points'
  ],
  function ()
  {
    
    Route::get( '/', 'PointsController@index' )->name( 'points' );
    
    // DEPRECATED:
    Route::get( '/getPoints', 'PointsController@get' )->name( 'getPoints' );
    
    Route::post( '/postPoints/', 'PointsController@post' )->name( 'postPoints' );
    
    Route::delete( '/{id}', 'PointsController@delete' )->name( 'pointsdelete' );
    
    Route::post( '/restore/{id}', 'PointsController@restore' )->name( 'pointsRestore' );

  }
);

Route::post( '/admin/clear/', 'PointsController@post' )->name( 'admin.cache' );
Route::post( '/admin/refresh/', 'PointsController@post' )->name( 'admin.refresh' );

/** END: POINTS ADMIN ROUTES **************************************************/

/** BEGIN: TWITTER HASHTAG ADMIN ROUTES ***************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'twitter-hashtags'
  ],
  function ()
  {
    Route::get( '/', 'TwitterHashtagConfigController@index' )->name( 'twitter-hashtags' );
    Route::post( '/add', 'TwitterHashtagConfigController@create' )->name( 'twitter-hashtags.add' );
    Route::get( '/enable/{id}', 'TwitterHashtagConfigController@enable' )->name( 'twitter-hashtags.enable' );
    Route::get( '/disable/{id}', 'TwitterHashtagConfigController@disable' )->name( 'twitter-hashtags.disable' );
    Route::get( '/delete/{id}', 'TwitterHashtagConfigController@delete' )->name( 'twitter-hashtags.delete' );
  }
);
/** END: TWITTER HASHTAG ADMIN ROUTES *****************************************/

/** BEGIN: APPWORKS POSTS ADMIN ROUTES ****************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'appworks-posts'
  ],
  function ()
  {

    Route::get( '/dashboard', 'SocialCardPostsController@index' )->name( 'appworks-posts.dashboard' );

    Route::get( '/approve/{id}', 'SocialCardPostsController@approve' );
    Route::get( '/reject/{id}', 'SocialCardPostsController@reject' );

    Route::get( '/feature/{id}', 'SocialCardPostsController@feature' );
    Route::get( '/unfeature/{id}', 'SocialCardPostsController@unfeature' );

    Route::delete( '/delete/{id}', 'SocialCardPostsController@delete' );

  }
);
/** END: APPWORKS POSTS ADMIN ROUTES ******************************************/

/** BEGIN: TWEETS ADMIN ROUTES ************************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'tweets'
  ],
  function ()
  {

    Route::get( '/dashboard', 'SocialCardTweetsController@index' )->name( 'tweets.dashboard' );

    Route::get( '/approve/{id}', 'SocialCardTweetsController@approve' );
    Route::get( '/reject/{id}', 'SocialCardTweetsController@reject' );

    Route::get( '/feature/{id}', 'SocialCardTweetsController@feature' );
    Route::get( '/unfeature/{id}', 'SocialCardTweetsController@unfeature' );

    Route::delete( '/delete/{id}', 'SocialCardTweetsController@delete' );

  }
);
/** END: TWEETS ADMIN ROUTES **************************************************/

/** BEGIN: LEADERBOARD ADMIN ROUTES *******************************************/
Route::group(
  [
    'middleware' => [ 'auth' ],
    'prefix'     => 'leaderboard'
  ],
  function ()
  {

    Route::get( '/', 'LeaderboardController@index' )->name( 'leaderboard' );

    Route::get( '/create', 'LeaderboardController@create_form' )->name( 'leaderboard.create' );
    Route::post( '/create', 'LeaderboardController@create' )->name( 'leaderboard.create' );

    Route::get( '/edit/{id}', 'LeaderboardController@edit' )->name( 'leaderboard.edit' );
    Route::post( '/edit/{id}', 'LeaderboardController@update' )->name( 'leaderboard.update' );

    Route::get( '/delete/{id}', 'LeaderboardController@delete' )->name( 'leaderboard.delete' );

    Route::get( '/bump-order-down/{id}', 'LeaderboardController@bumpOrderDown' );
    Route::get( '/bump-order-up/{id}', 'LeaderboardController@bumpOrderUp' );

  }
);
/** END: LEADERBOARD ADMIN ROUTES *********************************************/

/** BEGIN: SOCIAL WALL ROUTES *************************************************/
Route::group(
  [
    'namespace'  => 'SocialWall',
    'middleware' => []
  ],
  function ()
  {

    /** BEGIN: SOCIAL WALL ------------------------------------------------- **/
    Route::get( '/social-wall', 'SocialWallController@index' )->name( 'social-wall' );
    /** END: SOCIAL WALL --------------------------------------------------- **/

    /** BEGIN: EXAMPLE VUE COMPONENT USAGE --------------------------------- **/
    Route::get( '/example-logo-screen', function ( Request $request ) {
      return(
        view( 'social-wall.example-logo-screen' )
        ->with(
          [
          ]
        )
      );
    });
    Route::get( '/example-scoreboard-teams', function ( Request $request ) {
      return(
        view( 'social-wall.example-scoreboard-teams' )
        ->with(
          [
          ]
        )
      );
    });
    Route::get( '/example-scoreboard-team-members', function ( Request $request ) {
      return(
        view( 'social-wall.example-scoreboard-team-members' )
        ->with(
          [
          ]
        )
      );
    });
    Route::get( '/example-social-cards', function ( Request $request ) {
      return(
        view( 'social-wall.example-social-cards' )
        ->with(
          [
          ]
        )
      );
    });

    Route::get( '/example-leaderboard-screens', function ( Request $request ) {
      return(
        view( 'social-wall.example-leaderboard-screens' )
        ->with(
          [
          ]
        )
      );
    });
    /** END: EXAMPLE VUE COMPONENT USAGE ----------------------------------- **/

  }
);
/** END: SOCIAL WALL ROUTES ***************************************************/

// Touch Screen Routes

Route::get('/touchscreen','TouchScreenController@index');
Route::get('/getSchedule','TouchScreenController@schedule');
Route::get('/getExpoStands','TouchScreenController@ExpoStands');


// End Touch Screen Routes