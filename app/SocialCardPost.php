<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use App\iSocialCard;
use App\SocialCardBase;

class SocialCardPost extends SocialCardBase implements iSocialCard
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
    'post_id',
    'post_text',
    'lang',
    'first_name',
    'last_name',
    'title',
    'company',
    'profile_photo',
    'appworks_event_id',
    'game_team_uuid',
    'image'
  ];

  /****************************************************************************/

  public $sortable = [
    'card_created_at',
    'post_id',
    'post_text',
    'lang',
    'first_name',
    'last_name',
    'title',
    'company',
    'profile_photo',
    'appworks_event_id',
    'game_team_uuid',
    'image'
  ];

  /** VIRTUAL ATTRIBUTES ******************************************************/

  public $card_type = "appworks_post";

  /** RELATIONSHIPS ***********************************************************/

  // NONE

  /** MUTATORS ****************************************************************/

  // NONE

  /** ACCESSORS ***************************************************************/

  public function getCardVueIdAttribute ()
  {
    $this->card_vue_id = $this->card_type . '_' . $this->post_id;
    return( $this->card_vue_id );
  }

  /****************************************************************************/

}
