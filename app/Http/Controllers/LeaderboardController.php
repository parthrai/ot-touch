<?php

namespace App\Http\Controllers;

use Auth;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Leaderboard;
use App\ScreenSetting;

class LeaderboardController extends Controller
{

  /****************************************************************************/

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function __construct()
  {
    // $this->middleware('auth');
  }

  /****************************************************************************/

  public function index ( Request $request )
  {

    $leaderboard = Leaderboard::orderBy('orderis')->get();

    return(
      view( 'leaderboard.index' )
      ->with(
        [
          'leaderboards' => $leaderboard
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request )
  {

    return( view( 'leaderboard.create' ) );

  }

  /****************************************************************************/

  public function create ( Request $request )
  {

    $leaderboard              = new Leaderboard;
    $leaderboard->description = $request->input( 'description' );

    // TODO: Check for failure here:
    $this->StoreImages( $request, $leaderboard, false );

    $leaderboard->orderis = $request->input( 'orderis' );
    $leaderboard->save();

    return(
      redirect( route('leaderboard') )
      ->with(
        [
          'flash_success' => 'New Leaderboard Added'
        ]
      )
    );

  }

  /****************************************************************************/

  private function StoreImages ( Request $request, Leaderboard $leaderboard, $delete_old = false )
  {

    foreach( Leaderboard::$image_sizes as $image_size )
    {

      if( $image_size != Leaderboard::$image_sizes[0] )
      {

        if( $request->file( $image_size ) == null )
        {
          $leaderboard->{$image_size} = $leaderboard->{Leaderboard::$image_sizes[0]};
        }

      }
      else
      {

        try
        {

          $filename = join(
            '.',
            [
              uniqid( 'leaderboard', true ),
              $request->file( $image_size )->getClientOriginalExtension()
            ]
          );

          if( $delete_old == true )
          {
            try
            {
              unlink( storage_path( 'app/public/' . $leaderboard->{$image_size} ) );
            }
            catch( ErrorException $ex )
            {
              // NO-OP
            }
            catch( Exception $ex )
            {
              // NO-OP
            }
          }

          $request->file( $image_size )->storeAs( 'public', $filename );

          $leaderboard->{$image_size} = $filename;

        }
        catch( Exception $ex )
        {
          $leaderboard->{$image_size} = null;
        }

      }

    }

  }

  /****************************************************************************/

  public function edit ( Request $request, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      return(
        view( 'leaderboard.update' )
        ->with(
          [
            'leaderboard' => $leaderboard
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
            'flash_error' => 'Leaderboard Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      $leaderboard->description = $request->input( 'description' );
      $this->StoreImages( $request, $leaderboard, true );
      $leaderboard->orderis = $request->input( 'orderis' );
      $leaderboard->save();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Leaderboard Updated'
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
            'flash_error' => 'Leaderboard Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      foreach( Leaderboard::$image_sizes as $image_size )
      {
        try
        {
          unlink( storage_path( 'app/public/' . $leaderboard->{$image_size} ) );
        }
        catch( Exception $ex )
        {
          // NO-OP
        }
      }

      $leaderboard->delete();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Leaderboard Deleted'
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
            'flash_error' => 'Leaderboard Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderDown ( Request $request, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      $new_order = $leaderboard->orderis - 1;

      if( $new_order <= 0 )
      {
        $new_order = 1;
      }

      $leaderboard->orderis = $new_order;
      $leaderboard->save();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Leaderboard Order Adjusted'
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
            'flash_error' => 'Leaderboard Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function bumpOrderUp ( Request $request, $id )
  {

    $leaderboard = Leaderboard::find( $id );

    if( isset( $leaderboard ) )
    {

      $new_order            = $leaderboard->orderis + 1;
      $leaderboard->orderis = $new_order;
      $leaderboard->save();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Leaderboard Order Adjusted'
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
            'flash_error' => 'Leaderboard Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function get ()
  {

    $leaderboards = Leaderboard::orderBy( 'orderis', 'asc' )
    ->get(); 

    foreach( $leaderboards as $leaderboard )
    {
      foreach( Leaderboard::$image_sizes as $image_size )
      {
        $leaderboard->{$image_size} = asset( Storage::url( $leaderboard->{$image_size} ) );
      }
    }

    return(
      response()
      ->json( $leaderboards )
      ->header( 'Access-Control-Allow-Origin:', '*' )
    );

  }

  /****************************************************************************/

  public function get_screens ( Request $request )
  {

    $screen_settings = ScreenSetting::get();

    return(
      response()
      ->json( $screen_settings )
      ->header( 'Access-Control-Allow-Origin:', '*' )
    );

  }

  /****************************************************************************/

}
