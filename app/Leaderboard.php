<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Leaderboard extends Model
{

  /****************************************************************************/

  public static $image_sizes      = [ 'image_xs', 'image_sm', 'image_md', 'image_lg' ];
  public static $image_size_codes = [ 'xs', 'sm', 'md', 'lg' ];

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'description',
    'image_xs',
    'image_sm',
    'image_md',
    'image_lg',
    'orderis'
  ];

  /****************************************************************************/

  /*
  *   Get list of images orders to use in the competition screens view.
  *
  */
  public static function GetLeaderboardOrders ()
  {

    $image_list   = [];
    $leaderboards = Leaderboard::orderBy( 'orderis', 'ASC' )->get(); 

    foreach( $leaderboards as $leaderboard )
    {
      array_push( $image_list, $leaderboard->orderis );
    }

    return( $image_list );

  }

  /****************************************************************************/

}
