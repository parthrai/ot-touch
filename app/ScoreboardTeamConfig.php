<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoreboardTeamConfig extends Model
{

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'hashtag',
    'hex_background_color',
    'hex_text_color',
    'invisible'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'invisible' => 'boolean'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /****************************************************************************/

  private static $TeamDefaults = [
    'Blue' => [
      'hashtag'              => 'BL',
      'hex_background_color' => '#2E3D98',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Grey' => [
      'hashtag'              => 'GR',
      'hex_background_color' => '#7E929F',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Purple' => [
      'hashtag'              => 'PL',
      'hex_background_color' => '#4F3690',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Red' => [
      'hashtag'              => 'RD',
      'hex_background_color' => '#D92A32',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Teal' => [
      'hashtag'              => 'TL',
      'hex_background_color' => '#00B8BA',
      'hex_text_color'       => '#FFFFFF',
      'invisible'               => false
    ],
    'Clear' => [
      'hashtag'              => 'CL',
      'hex_background_color' => '#09BCEF',
      'hex_text_color'       => '#000000',
      'invisible'               => true
    ]
  ];

  /** RELATIONSHIPS ***********************************************************/

  // NONE

  /** MUTATORS ****************************************************************/

  public function setHashtagAttribute ( $value )
  {
    $hashtag = str_replace( '#', '', $value );
    $this->attributes['hashtag'] = $hashtag;
  }

  /** ---------------------------------------------------------------------- **/

  public function setHexBackgroundColorAttribute ( $value )
  {
    $color = $value;
    if( preg_match( '/^#[0-9a-fA-F]+$/', $color ) )
    {
      $color = strtoupper( $value );
    }
    $this->attributes['hex_background_color'] = $color;
  }

  /** ---------------------------------------------------------------------- **/

  public function setHexTextColorAttribute ( $value )
  {
    $color = $value;
    if( preg_match( '/^#[0-9a-fA-F]+$/', $color ) )
    {
      $color = strtoupper( $value );
    }
    $this->attributes['hex_text_color'] = $color;
  }

  /****************************************************************************/
  
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public static function ResetToDefaultTeams ()
  {

    DB::beginTransaction();
    ScoreboardTeamConfig::whereNotNull('id')->forceDelete();
    DB::commit();

    foreach( ScoreboardTeamConfig::$TeamDefaults as $name => $struct )
    {

      $team                       = new ScoreboardTeamConfig();
      $team->name                 = $name;
      $team->hashtag              = $struct['hashtag'];
      $team->hex_background_color = $struct['hex_background_color'];
      $team->hex_text_color       = $struct['hex_text_color'];
      $team->invisible            = $struct['invisible'];
      $team->save();

    }

  }

  /****************************************************************************/

  /**
  * Load team names.
  *
  * @return Array
  */
  public static function GetTeamNames ()
  {
    $team_names = ScoreboardTeamConfig::where( 'invisible', '=', false )
    ->pluck( 'name' )
    ->toArray();
    return( $team_names );
  }

  /****************************************************************************/
  
  /**
  * Load team names.
  *
  * @return Array
  */
  public static function GetInvisibleTeamNames ()
  {
    $team_names = ScoreboardTeamConfig::where( 'invisible', '=', true )
    ->pluck( 'name' )
    ->toArray();
    return( $team_names );
  }

  /****************************************************************************/
  
  /**
  * Load hashtags into associative array.
  *
  * @return Array
  */
  public static function GetHashtags ( bool $DowncaseTeamName = false )
  {
    
    $hashtags = [];
    $teams    = ScoreboardTeamConfig::where( 'invisible', '=', false )->get();

    foreach( $teams as $team )
    {
      $team_name = $team->name;
      if( $DowncaseTeamName )
      {
        $team_name = strtolower( $team_name );
      }
      $hashtags[$team_name] = $team->hashtag;
    }

    return( $hashtags );

  }

  /****************************************************************************/
  
  /**
  * Load team colours into an array of arrays.
  *
  * @return Array
  */
  public static function GetTeamColors ( bool $DowncaseTeamName = false )
  {

    $colours = [];
    $teams   = ScoreboardTeamConfig::where( 'invisible', '=', false )->get();
    
    foreach( $teams as $team )
    {
      $team_name = $team->name;
      if( $DowncaseTeamName )
      {
        $team_name = strtolower( $team_name );
      }
      $colours[$team_name] = [
        'hex_background_color' => $team->hex_background_color,
        'hex_text_color'       => $team->hex_text_color
      ];
    }

    return( $colours );

  }

  /****************************************************************************/

}
