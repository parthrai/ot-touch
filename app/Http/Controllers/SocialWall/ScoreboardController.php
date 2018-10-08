<?php

namespace App\Http\Controllers\SocialWall;

use Validator;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;

use App\ScoreboardTeamConfig;
use App\ScoreboardTeam;
use App\ScoreboardMember;

class ScoreboardController extends Controller
{

  /****************************************************************************/

  protected $cache_duration = 1; // Minutes

  /****************************************************************************/

  /**
  * Get scoreboard team scores.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetTeamScores ( Request $request )
  {

    $teams          = null;
    $excluded_teams = ScoreboardTeamConfig::GetInvisibleTeamNames();
    $cache_key      = 'TeamScores';

    if( Cache::tags( [ 'Scoreboard' ] )->has( $cache_key ) )
    {
      $teams = Cache::tags( [ 'Scoreboard' ] )->get( $cache_key, null );
    }


    $teams = null;
    

    if( ! isset( $teams ) )
    {

      $teams = ScoreboardTeam::with( 'members' )
      ->whereNotIn( 'team_name', $excluded_teams )
      ->orderBy( 'points_aggregate', 'desc' )
      ->get();

      if( isset( $teams ) )
      {
        Cache::tags( [ 'Scoreboard' ] )->put( $cache_key, $teams, 5 );
      }

    }

    return(
      response()
      ->json( $teams )
    );

  }

  /****************************************************************************/

  /**
  * Get scoreboard team member top scores.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetAllTopTeamMembersScores ( Request $request )
  {

    $members   = null;
    $cache_key = 'AllTeamMembersScores';

    if( Cache::tags( [ 'Scoreboard' ] )->has( $cache_key ) )
    {
      $members = Cache::tags( [ 'Scoreboard' ] )->get( $cache_key, null );
    }

    if( ! isset( $members ) )
    {

      $members = ScoreboardMember::with( 'team' )
      ->orderBy( 'points', 'desc' )
      ->get();
    
      if( isset( $members ) )
      {
        Cache::tags( [ 'Scoreboard' ] )->put( $cache_key, $members, 1 );
      }

    }

    return(
      response()
      ->json( $members )
    );

  }

  /****************************************************************************/

  /**
  * Get scoreboard team member top scores.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetTopTeamMembersScores ( Request $request, $team_name )
  {

    $members        = null;
    $excluded_teams = ScoreboardTeamConfig::GetInvisibleTeamNames();
    $cache_key      = 'TeamMembersScores:' . $team_name;

    if( Cache::tags( [ 'Scoreboard' ] )->has( $cache_key ) )
    {
      $members = Cache::tags( [ 'Scoreboard' ] )->get( $cache_key, null );
    }

    if( ! isset( $members ) )
    {

      $members = ScoreboardMember::with( 'team' )
      ->whereHas(
        'team', function ( $query ) use ( $team_name, $excluded_teams )
        {
          $query->where( 'team_name', '=', $team_name )
          ->whereNotIn( 'team_name', $excluded_teams );
        }  
      )
      ->orderBy( 'points', 'desc' )
      ->limit( 5 )
      ->get();
  
      if( isset( $members ) )
      {
        Cache::tags( [ 'Scoreboard' ] )->put( $cache_key, $members, $this->cache_duration );
      }

    }

    return(
      response()
      ->json( $members )
    );

  }

  /****************************************************************************/

}
