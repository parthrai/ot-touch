<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\SocialCardLookup;
use App\SocialCardPost;

class SocialCardPostsController extends Controller
{

  /****************************************************************************/

  public function index ( Request $request )
  {

    $cards = null;

    if( $request->input('q') !== null )
    {

      $query = $request->input('q');

      $cards = SocialCardPost::where( 'post_text', 'RLIKE', $query )
      ->orWhere( 'first_name', 'RLIKE', $query )
      ->orWhere( 'last_name', 'RLIKE', $query )
      ->orWhere( 'company', 'RLIKE', $query )
      ->sortable()
      ->orderBy( 'post_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

      $cards->appends( [ 'q' => $query ] );

    }
    else
    {

      $cards = SocialCardPost::sortable()
      ->orderBy( 'post_id', 'DESC' )
      ->limit( 7 )
      ->paginate( 15 );

    }

    return(
      view( 'social-cards.appworks-posts.index' )
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

    $card = SocialCardPost::find( $id );

    if( isset( $card ) )
    {

      $card->SetApproved( true );

      return(
        back()
        ->with(
          [
            'flash_success' => 'Post Approved'
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
            'flash_error' => 'No such post!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function reject ( Request $request, $id )
  {

    $card = SocialCardPost::find( $id );

    if( isset( $card ) )
    {

      $card->SetApproved( false );

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Post Rejected'
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
            'flash_error' => 'No such post!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function feature ( Request $request, $id )
  {

    $card = SocialCardPost::find( $id );

    if( isset( $card ) )
    {

      $card->SetFeatured( true );

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Post Featured'
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
            'flash_error' => 'No such post!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function unfeature ( Request $request, $id )
  {

    $card = SocialCardPost::find( $id );

    if( isset( $card ) )
    {

      $card->SetFeatured( false );

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Post Unfeatured'
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
            'flash_error' => 'No such post!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $id )
  {

    $card = SocialCardPost::find( $id );

    if( isset( $card ) )
    {

      $card->delete();

      Cache::tags( [ 'SocialCards' ] )->flush();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Post Deleted'
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
            'flash_error' => 'No such post!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
