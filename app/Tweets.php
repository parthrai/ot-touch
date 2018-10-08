<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tweets extends Model
{

  /****************************************************************************/

  use Sortable;

  /****************************************************************************/

  public $sortable      = [ 'tweet_id', 'tweet_text', 'screen_name', 'created_at' ];
  protected $dates      = [ 'created_at', 'deleted_at' ];
  protected $primaryKey = 'tweet_id';
  public $incrementing  = false;
  public $keyType       = 'bigInteger';

  /****************************************************************************/

  public function getCreatedAtAttribute ( $value )
  {
    return strtotime( $value );
  }

  /****************************************************************************/

  public function latest ()
  {
    return $this->orderBy( 'created_at', 'desc' );
  }

  /****************************************************************************/

  public function tweetmedia ()
  {
    //return $this->hasMany(‘App\Comment’, ‘foreign_key’, ‘local_key’);
    return $this->hasOne( 'App\TweetMedia', 'tweet_id', 'tweet_id' );
  }

  /****************************************************************************/

}
