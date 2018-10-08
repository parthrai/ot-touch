<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\ScoreboardTeamConfig;
use App\ScoreboardMember;

class ScoreboardTeam extends Model
{

  /****************************************************************************/

  use SoftDeletes;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'team_name',
    'points',
    'points_aggregate'
  ];

  /****************************************************************************/

  protected $team_hashtag          = null;
  protected $team_background_color = null;
  protected $team_text_color       = null;
  
  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /****************************************************************************/

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  public $appends = [
    'team_hashtag',
    'team_background_color',
    'team_text_color'
  ];

  /** RELATIONSHIPS ***********************************************************/

  public function members ()
  {
    return( $this->hasMany( 'App\ScoreboardMember', 'team_id' ) );
  }

  /** MUTATORS ****************************************************************/

  // NONE

  /** ACCESSORS ***************************************************************/

  public function getTeamHashtagAttribute ()
  {
    try
    {
      $team = ScoreboardTeamConfig::where( 'name', '=', $this->team_name )
      ->first();
      $this->team_hashtag = $team->hashtag;
    }
    catch( \Exception $ex )
    {
      // NO-OP
    }
    return( $this->team_hashtag );
  }

  /** ---------------------------------------------------------------------- **/

  public function getTeamBackgroundColorAttribute ()
  {
    try
    {
      $team = ScoreboardTeamConfig::where( 'name', '=', $this->team_name )
      ->first();
      $this->team_background_color = $team->hex_background_color;
    }
    catch( \Exception $ex )
    {
      $this->team_background_color = "#000000";
    }
    return( $this->team_background_color );
  }

  /** ---------------------------------------------------------------------- **/


  public function getTeamTextColorAttribute ()
  {
    try
    {
      $team = ScoreboardTeamConfig::where( 'name', '=', $this->team_name )
      ->first();
      $this->team_text_color = $team->hex_text_color;
    }
    catch( \Exception $ex )
    {
      $this->team_text_color = "#000000";
    }
    return( $this->team_text_color );
  }
  /****************************************************************************/

  /**
  * Get array of team names and hashtags.
  *
  * @return Array
  */
  public static function GetTeamSets ( $sets )
  {

    $excluded_teams = ScoreboardTeamConfig::GetInvisibleTeamNames();
    $teams          = ScoreboardTeam::whereNotIn( 'team_name', $excluded_teams )
    ->orderBy( 'team_name', 'asc' )
    ->get();

    $count           = 0;
    $set             = 0;
    $boundary        = intval( count( $teams ) / $sets );
    $team_sets       = [];
    $team_sets[$set] = [];

    foreach( $teams as $team )
    {

      $team_details = ScoreboardTeamConfig::where( 'name', '=', $team->team_name )->first();

      $team_sets[$set][$team->team_name] = [
        'team_name'             => $team->team_name,
        'team_hashtag'          => $team_details->hashtag,
        'team_background_color' => $team_details->hex_background_color,
        'team_text_color'       => $team_details->hex_text_color
      ];

      $count++;

      if( $count % $boundary == 0 )
      {
        $set++;
        $team_sets[$set] = [];
        $count = 0;
      }

    }

    return( $team_sets );

  }

  /****************************************************************************/

}
