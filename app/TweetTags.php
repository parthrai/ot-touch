<?php

namespace App;

use Composer\Cache;

use Illuminate\Database\Eloquent\Model;

class TweetTags extends Model
{

  /****************************************************************************/

  protected $table      = 'tweet_tags';
  protected $primaryKey = 'tweet_id';
  public $incrementing  = false;
  public $keyType       = 'bigInteger';

  /****************************************************************************/

  public function getTagAttribute ( $value )
  {
    return( strtolower( $value ) );
  }

  /****************************************************************************/

}
