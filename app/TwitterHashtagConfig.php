<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException as QueryException;

class TwitterHashtagConfig extends Model
{

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'hashtag',
    'enabled'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'enabled' => 'boolean'
  ];

  /****************************************************************************/

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  /** RELATIONSHIPS ***********************************************************/

  // NONE

  /** MUTATORS ****************************************************************/

  public function setHashtagAttribute ( $value )
  {
    $hashtag = str_replace( '#', '', $value );
    $this->attributes['hashtag'] = $hashtag;
  }

  /** ACCESSORS ***************************************************************/

  // NONE

  /****************************************************************************/

}
