<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\SocialCardHashtag;
use App\SocialCardLookup;

class SocialCardHashtagLookup extends Model
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
    'card_id',
    'hashtag_id'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /** RELATIONSHIPS ***********************************************************/

  public function card ()
  {
    return( $this->hasOne( 'App\SocialCardLookup', 'id' ) );
  }

  /** ---------------------------------------------------------------------- **/

  public function hashtag ()
  {
    return( $this->hasOne( 'App\SocialCardHashtag', 'id' ) );
  }

  /** MUTATORS ****************************************************************/

  // NONE
  
  /****************************************************************************/

}
