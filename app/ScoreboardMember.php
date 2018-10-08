<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\ScoreboardTeam;
use App\Observers\ScoreboardMemberObserver;

class ScoreboardMember extends Model
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
    'team_id',
    'member_name',
    'points'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /** EVENTS ******************************************************************/

  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    'created' => ScoreboardMemberObserver::class
  ];

  /** RELATIONSHIPS ***********************************************************/

  public function team ()
  {
    return( $this->belongsTo( 'App\ScoreboardTeam', 'team_id' ) );
  }

  /** MUTATORS ****************************************************************/

  // NONE

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

}
