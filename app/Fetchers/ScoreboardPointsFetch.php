<?php

namespace App\Fetchers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Support\Facades\Cache;

use App\Point;

use App\ScoreboardTeamConfig;
use App\ScoreboardTeam;
use App\ScoreboardMember;

use App\SocialCardHashtagLookup;
use App\SocialCardHashtag;
use App\SocialCardLookup;
use App\SocialCardTweet;

class ScoreboardPointsFetch
{

  /****************************************************************************/

  private $show_output     = false;
  protected $team_hashtags = array(); // Will fill with hashtags from .env

  /****************************************************************************/

  /**
   * Create a new instance.
   *
   * @return void
   */
  public function __construct ( Bool $show_output = false )
  {
    $this->show_output   = $show_output;
    $this->team_hashtags = ScoreboardTeamConfig::GetHashtags();
  }

  /****************************************************************************/

  /**
   * Fetch points from AppWorks.
   *
   * @return Boolean
   */
  public function FetchPoints ()
  {

    $dirty   = false;
    $http    = new Client();
    $package = null;

    try
    {

      $response = $http->request(
        'GET',
        'http://appworks.opentext.com/appworks-conference-service/api/v2/games/totals',
        [
          'verify'      => false,
          'http_errors' => false,
          'headers'     => [
            'Content-Type'       => 'application/json',
            'Accept'             => 'application/json',
            'x-ew-app-key'       => getenv( 'AW_APP_KEY' ),
            'AW_EVENTS_EVENT_ID' => getenv( 'AW_EVENTS_EVENT_ID' )
          ],
        ]
      );

      $package = json_decode( (string) $response->getBody(), false );

    }
    catch( \Exception $ex )
    {
      $package = null;
    }
    
    if( isset( $package ) )
    {
      // TODO:: Needs more error handling:
      $this->InsertOrUpdateTeamScores( $package->overallScores );
      $this->InsertOrUpdateTeamMemberScores( $package->teamLeaders );
      $dirty = true;
    }

    return( $dirty );

  }

  /****************************************************************************/

  private function InsertOrUpdateTeamScores ( $package )
  {

    if( $this->show_output ) echo( "TEAM SCORES:\n" );

    foreach( $package as $team_name => $points )
    {

      if( $this->show_output ) echo( "\tTEAM: " . $team_name . " :: " . $points . "\n" );

      $team = ScoreboardTeam::where( 'team_name', '=', $team_name )->first();

      if( ! isset( $team ) )
      {
        $team = new ScoreboardTeam();
      }

      $team->team_name    = $team_name;
      $team->points       = $points;
      $team->save();

    }

  }

  /****************************************************************************/

  public function RecalculateTeamScores ()
  {

    if( $this->show_output ) echo( "RECALCULATING TEAM POINTS\n" );

    $teams = ScoreboardTeam::get();

    foreach( $teams as $team )
    {

      if( ! array_key_exists( $team->team_name, $this->team_hashtags ) )
      {
        continue;        
      }

      if( $this->show_output ) echo( "\t" . $team->team_name . "\n" );

      $team_hashtag = $this->team_hashtags[$team->team_name];
      $game_points  = 0;
      $tweet_points = 0;
      $points       = Point::where( 'team', '=', strtolower( $team->team_name ) )->pluck('points')->sum();
      $hashtag      = SocialCardHashtag::where( 'hashtag_text', '=', strtolower( $team_hashtag ) )->first();

      if( isset( $points ) && ( $points > 0 ) )
      {
        $game_points = $points;
      }

      if( isset( $hashtag ) )
      {

        $count = SocialCardHashtagLookup::with( 'card' )
        ->where( 'hashtag_id', '=', $hashtag->id )
        ->count();

        if( isset( $count ) && ( $count > 0 ) )
        {
          // TODO: Make tweet points value a configurable setting
          $tweet_points = ( $count * 50 ); // 1 tweet = 50 points
        }

      }

      $team->points_aggregate = $team->points + $game_points + $tweet_points;
      $team->save();

      if( $this->show_output ) echo( "\t\tGAME POINTS: " . $team->points . "\n" );
      if( $this->show_output ) echo( "\t\tTWEET POINTS: " . $tweet_points . "\n" );
      if( $this->show_output ) echo( "\t\tAGGREGATE POINTS: " . $team->points_aggregate . "\n" );

    }

  }

  /****************************************************************************/

  private function InsertOrUpdateTeamMemberScores ( $package )
  {

    if( $this->show_output ) echo( "TEAM MEMBER SCORES:\n" );

    foreach( $package as $team_name => $members )
    {

      if( $this->show_output ) echo( "\tTEAM: " . $team_name . "\n" );

      $team = ScoreboardTeam::where( 'team_name', '=', $team_name )->first();

      foreach( $members as $member )
      {

        $name   = $member->name;
        $points = $member->total;

        if( $this->show_output ) echo( "\t\tTEAM MEMBER: " . $name . " :: " . $points . "\n" );

        $team_member = ScoreboardMember::where(
          [
            [ 'team_id', '=', $team->id ],
            [ 'member_name', '=', $name ]
          ]
        )->first();

        if( ! isset( $team_member ) )
        {
          $team_member = new ScoreboardMember();
        }

        $team_member->team_id     = $team->id;
        $team_member->member_name = $name;
        $team_member->points      = $points;
        $team_member->save();
  
      }

    }

  }

  /****************************************************************************/

}
