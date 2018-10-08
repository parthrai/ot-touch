<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use App\iSocialCard;
use App\SocialCardBase;
use App\Observers\SocialCardObserver;

class SocialCardTweet extends SocialCardBase implements iSocialCard
{

  /****************************************************************************/

  use Sortable;

  /****************************************************************************/

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'card_created_at',
    'tweet_id',
    'tweet_text',
    'lang',
    'user_name',
    'user_screen_name',
    'user_location',
    'user_url',
    'user_image',
    'image'
  ];

  /****************************************************************************/

  public $sortable = [
    'card_created_at',
    'tweet_id',
    'tweet_text',
    'lang',
    'user_name',
    'user_screen_name',
    'user_location',
    'user_url',
    'user_image',
    'image'
  ];

  /** VIRTUAL ATTRIBUTES ******************************************************/

  public $card_type = "tweet";

  /** EVENTS ******************************************************************/

  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    'created' => SocialCardObserver::class,
    'saved'   => SocialCardObserver::class
  ];

  /** RELATIONSHIPS ***********************************************************/

  // NONE

  /** MUTATORS ****************************************************************/

  // NONE

  /** ACCESSORS ***************************************************************/

  public function getCardVueIdAttribute ()
  {
    $this->card_vue_id = $this->card_type . '_' . $this->tweet_id;
    return( $this->card_vue_id );
  }

  /****************************************************************************/

}
