<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\SocialCardLookup;
use App\SocialCardTweet;

class SocialCardTweetsController extends Controller
{

  /****************************************************************************/

  public function index ( Request $request )
  {

    $cards = null;

    if( $request->input('q') !== null )
    {

      $query = $request->input('q');

      $cards = SocialCardTweet::where( 'user_screen_name', 'RLIKE', $query )
      ->orWhere( 'tweet_text', 'RLIKE', $query )
      ->sortable()
      ->orderBy( 'tweet_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

      $cards->appends( [ 'q' => $query ] );

    }
    else
    {

      $cards = SocialCardTweet::sortable()
      ->orderBy( 'tweet_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

    }

    return(
      view( 'social-cards.tweets.index' )
      ->with(
        [
          'request' => $request,
          'cards'   => $cards
        ]
      )
    );

  }

  /****************************************************************************/

  public function approve ( Request $request, $id )
  {

    $card = SocialCardTweet::find( $id );

    if( isset( $card ) )
    {

      $card->SetApproved( true );

      return(
        back()
        ->with(
          [
            'flash_success' => 'Tweet Approved'
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error' => 'No such tweet!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function reject ( Request $request, $id )
  {

    $card = SocialCardTweet::find( $id );

    if( isset( $card ) )
    {

      $card->SetApproved( false );

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Tweet Rejected'
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error' => 'No such tweet!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function feature ( Request $request, $id )
  {

    $card = SocialCardTweet::find( $id );

    if( isset( $card ) )
    {

      $card->SetFeatured( true );

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Tweet Featured'
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error' => 'No such tweet!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function unfeature ( Request $request, $id )
  {

    $card = SocialCardTweet::find( $id );

    if( isset( $card ) )
    {

      $card->SetFeatured( false );

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Tweet Unfeatured'
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error' => 'No such tweet!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $id )
  {

    $card = SocialCardTweet::find( $id );

    if( isset( $card ) )
    {

      $card->delete();

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Tweet Deleted'
          ]
        )
      );

    }
    else
    {

      return(
        back()
        ->with(
          [
            'flash_error' => 'No such tweet!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
