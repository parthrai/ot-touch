<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\iSocialCard;
use App\SocialCardLookup;
use App\Events\SocialCardsNewCard;

class SocialCardObserver
{

  /****************************************************************************/

  /**
   * Listen to the SocialCardLookup created event and fire events.
   *
   * @param  \App\iSocialCard $card
   * @return void
   */
  public function created ( iSocialCard $card )
  {

    $lookup = SocialCardLookup::where( 'social_card_id', '=', $card->id )->first();

    if( isset( $lookup ) )
    {
      $lookup->created_at = $card->card_created_at;
      $lookup->save();
    }

    SocialCardsNewCard::dispatch( $card );

  }

  /****************************************************************************/

  /**
   * Listen to the iSocialCard saved event.
   * Insert new record into SocialCardLookup table.
   *
   * @param  \App\iSocialCard $card
   * @return void
   */
  public function saved ( iSocialCard $card )
  {

    $lookup = SocialCardLookup::where( 'social_card_id', '=', $card->id )->first();

    if( ! isset( $lookup ) )
    {
      $lookup = new SocialCardLookup();
    }

    $lookup->social_card_id    = $card->id;
    $lookup->created_at        = $card->card_created_at;
    $lookup->social_card_type  = get_class( $card );

    $lookup->save();

  }

  /****************************************************************************/

}
