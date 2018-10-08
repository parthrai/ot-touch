<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TweetMedia extends Model
{

  /****************************************************************************/

  protected $table      = 'tweet_media';
  protected $primaryKey = 'tweet_id';
  public $incrementing  = false;
  public $keyType       = 'bigInteger';
  protected $fillable   = [ 'media' ];

  /****************************************************************************/

  public function tweets ()
  {
    return $this->belongsTo( 'App\Tweets', 'tweet_id', 'tweet_id' );
  }

  /****************************************************************************/

}
