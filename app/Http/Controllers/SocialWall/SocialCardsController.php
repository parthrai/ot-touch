<?php

namespace App\Http\Controllers\SocialWall;

use Twitter;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;

use App\SocialCardHashtag;
use App\SocialCardHashtagLookup;
use App\SocialCardLookup;
use App\SocialCardTweet;
use App\SocialCardPost;

class SocialCardsController extends Controller
{

  /****************************************************************************/

  # https://github.com/thujohn/twitter
  # https://packagist.org/packages/thujohn/twitter

  /****************************************************************************/

  private $cache_duration = 1;

  /****************************************************************************/

  /**
  * Get some Social Card items.
  *
  * @return \Illuminate\Http\Response
  */
  public function GetCards ( Request $request )
  {

    $max_items = $request->input( 'max_items' );
    $cards     = null;
    $cache_key = null;

    $ratios = [
      SocialCardPost::class  => 60,
      SocialCardTweet::class => 40
    ];

    if( ! isset( $max_items ) )
    {
      $max_items = 25;
    }

    $cache_key = 'GetCards:' . $max_items;

    if( Cache::tags( [ 'SocialCards' ] )->has( $cache_key ) )
    {
      //$cards = Cache::tags( [ 'SocialCards' ] )->get( $cache_key, null );
    }

    if( ! isset( $cards ) )
    {

      $cards      = array();
      $cards_list = [];

      foreach( $ratios as $card_type => $ratio )
      {
        
        $limit        = intval( ( $max_items / 100 ) * $ratio );

        $lookup_cards = SocialCardLookup::with( 'hashtags', 'social_card' )
        ->where(
          [
            [ 'approved', '=', 1 ],
            [ 'social_card_type', '=', $card_type ]
          ]
        )
        ->orderBy( 'created_at', 'desc' )
        ->limit( $limit )
        ->get();

        foreach ( $lookup_cards as $lookup_card )
        {
          if( isset( $lookup_card->social_card ) )
          {
            array_push( $cards_list, $lookup_card->social_card );
          }
        }

      }

      $cards_unsorted = collect( $cards_list );
      $cards_sorted   = $cards_unsorted->sortByDesc( 'card_created_at' );

      foreach( $cards_sorted as $card_key => $card_sorted )
      {
        array_push( $cards, $card_sorted );
      }

      if( isset( $cards ) )
      {
        Cache::tags( [ 'SocialCards' ] )->put( $cache_key, $cards, $this->cache_duration );
      }

    }

    return(
      response()
      ->json( $cards )
    );

  }

  /****************************************************************************/

}
