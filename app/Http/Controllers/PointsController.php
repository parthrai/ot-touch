<?php

namespace App\Http\Controllers;

use Auth;

use Predis\PredisException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\Point;
use App\ScoreboardTeamConfig;

use App\TweetTags; // TODO: Deprecate this

class PointsController extends Controller
{

  /****************************************************************************/

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index ( Request $request )
  {

    $this->middleware('auth');

    $teams        = ScoreboardTeamConfig::GetHashtags( true );
    $teams_colors = ScoreboardTeamConfig::GetTeamColors( true );

    if( $request->input('q') )
    {
      
      $query = $request->input('q');

      $search_results = Point::withTrashed()
      ->sortable()
      ->where( 'team', 'RLIKE', $query )
      ->orWhere( 'source', 'RLIKE', $query )
      ->paginate( 30 );

      $search_results->appends( [ 'q' => $query ] );

      return(
        view( 'points' )
        ->with(
          [
            'request'      => $request,
            'points'       => $search_results,
            'teams'        => $teams,
            'teams_colors' => $teams_colors
          ]
        )
      );

    }

    $points = Point::withTrashed()
    ->sortable()
    ->orderBy( 'updated_at', 'desc' )
    ->paginate( 15 );

    return(
      view('points')
      ->with(
        [
          'request'      => $request,
          'points'       => $points,
          'teams'        => $teams,
          'teams_colors' => $teams_colors
        ]
      )
    );

  }

  /****************************************************************************/

  public function delete ( Request $request, $id )
  {

    $points = Point::find( $id );

    try
    {
      $points->delete();
    }
    catch( \Exception $ex )
    {
      return( $ex->getMessage() );
    }

    return(
      back()
      ->with(
        [ 'flash_success' => 'Points Deleted' ]
      )
    );

  }

  /****************************************************************************/

  public function restore ( Request $request, $id )
  {

    Point::onlyTrashed()
    ->where( 'id', '=', $id )
    ->restore();
  
    return(
      back()
      ->with(
        [ 'flash_success' => 'Points Restored' ]
      )
    );

  }

  /****************************************************************************/

  // DEPRECATED:
  public function get ()
  {
    $points = Point::grab_points();
    return( response()->json( $points ) );
  }

  /****************************************************************************/

  // DEPRECATED:
  public static function grab()
{
header('Access-Control-Allow-Origin: *');

//@fixme: need to remove the appworks token from .env and add to backend
$headers = array();
$headers[] = 'Content-Type: application/json';
$headers[] = getenv('AW_APP_KEY').':'. getenv('AW_SECRET_TOKEN');
$headers[] = 'AW_EVENTS_EVENT_ID:'. getenv('AW_EVENTS_EVENT_ID');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://appworks.opentext.com/appworks-conference-service/api/v2/games/totals");

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

$server_output = curl_exec ($ch);



curl_close ($ch);



$pointsArray = json_decode($server_output, true);




if($pointsArray){
try{
Redis::hset('h','point-data-from-api',$server_output);
}
catch(\Exception $ex){
dd("redis down");
}


}


else

$pointsArray=json_decode(Redis::hget('h','point-data-from-api'),true);






//add the updated tweet scores to the over all scores
// dd($arr['overallScores']);

//add misc points to overall scores
$teamPoints = DB::table('points')
->select('team', DB::raw('sum(points) as points'))  //had to add the aggregate via raw
->groupBy('team')
->orderBy('team')
->where(function ($query) {
$query->where('team', 'like', 'grey')   //we use like because the case is sometimes different
->orWhere('team', 'like', 'blue')
->orWhere('team', 'like', 'purple')
->orWhere('team', 'like', 'red')
->orWhere('team', 'like', 'teal');
})
->whereNull('deleted_at')
->get();
$tweetPoints = DB::table('tweet_tags')
->select('tag', DB::raw('count(tweet_tags.tweet_id)*50 as points'))  //had to add the aggregate via raw
//@todo: no longer need this join as we no longer care about tweets
->join('tweets', 'tweet_tags.tweet_id', '=', 'tweets.tweet_id')
->groupBy('tweet_tags.tag')
->orderBy('tweet_tags.tag')
->where(function($query){
$query->where('tweet_tags.tag', 'like', 'gr')   //we use like because the case is sometimes different
->orWhere('tweet_tags.tag', 'like', 'bl')
->orWhere('tweet_tags.tag', 'like', 'pl')
->orWhere('tweet_tags.tag', 'like', 'rd')
->orWhere('tweet_tags.tag', 'like', 'tl');
})
/**
*  Decided 7/9/2018 by David Duggins and Steve Cittadini to remove this check.
*/
//->where('tweets.is_approved', 1)

->get();

$teamPoints = $teamPoints->toArray();


$tweetPoints = $tweetPoints->toArray();
$tweetpoint = ['Grey' => 0, 'Blue' => 0, 'Purple' => 0, 'Red' => 0, 'Teal' => 0];
$teampoint = ['Grey' => 0, 'Blue' => 0, 'Purple' => 0, 'Red' => 0, 'Teal' => 0];


foreach ($teamPoints as $teamPoint){

switch($teamPoint->team){
case 'blue':
$teampoint['Blue'] = $teamPoint->points;
break;
case 'purple':
$teampoint['Purple'] = $teamPoint->points;
break;
case 'grey':
$teampoint['Grey'] = $teamPoint->points;
break;
case 'red':
$teampoint['Red'] = $teamPoint->points;
break;
case 'teal':
$teampoint['Teal'] = $teamPoint->points;
break;

}

}


foreach ($tweetPoints as $tweetPoint){
switch($tweetPoint->tag){
case 'BL':
$tweetpoint['Blue'] = $tweetPoint->points;
break;
case 'PL':
$tweetpoint['Purple'] = $tweetPoint->points;
break;
case 'GR':
$tweetpoint['Grey'] = $tweetPoint->points;
break;
case 'RD':
$tweetpoint['Red'] = $tweetPoint->points;
break;
case 'TL':
$tweetpoint['Teal'] = $tweetPoint->points;
break;
}
}
$pointsArray['overallScores']['Grey'] = $pointsArray['overallScores']['Grey'] + $teampoint['Grey'] + $tweetpoint['Grey'];
$pointsArray['overallScores']['Blue'] = $pointsArray['overallScores']['Blue'] + $teampoint['Blue'] + $tweetpoint['Blue'];
$pointsArray['overallScores']['Purple'] = $pointsArray['overallScores']['Purple'] + $teampoint['Purple'] + $tweetpoint['Purple'];
$pointsArray['overallScores']['Red'] = $pointsArray['overallScores']['Red'] + $teampoint['Red'] + $tweetpoint['Red'];
$pointsArray['overallScores']['Teal'] = $pointsArray['overallScores']['Teal'] + $teampoint['Teal'] + $tweetpoint['Teal'];

return json_encode($pointsArray);

}

  /****************************************************************************/

  // DEPRECATED:
  static function report ()
  {
    return PointsController::grab();
  }

  /****************************************************************************/

  // DEPRECATED:
  public function grab_teams($team)
  {
    $points=TweetTags::all()
    ->where('tag','like',  $team )
    ->count('tweet_id');
    return $points;
  }


  public function post(Request $request)
{
$points = new Points;
if(!isset($request['points'][2])){
error_log('arcade points');

$points->points = $request['score'];
switch ($request['team']) {
case 'GR':
$points->team = "grey";
break;
case 'TL':
$points->team = "teal";
break;
case 'BL':
$points->team = "blue";
break;
case 'PL':
$points->team = "purple";
break;
case 'RD':
$points->team = "red";
break;
}
//$points->audit    = 99;
$points->source = "Arcade";
$points->points = $request['score'];
$points->audit = 99;


} else {

$points->points = $request['points'][0];
$points->team = $request['points'][1];
$points->source = "PointsApp";
$points->audit = $request['points'][2];
}
$points->save();
return back()->with(['flash_success' => 'New points Added']);


}

  /****************************************************************************/

}
