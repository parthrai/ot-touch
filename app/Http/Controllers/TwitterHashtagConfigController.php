<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\TwitterHashtagConfig;

class TwitterHashtagConfigController extends Controller
{

  /****************************************************************************/

  public function index ( Request $request )
  {

    $configs = TwitterHashtagConfig::orderBy( 'hashtag' )
    ->get();

    return(
      view( 'twitter-configs.index' )
      ->with(
        [
          'configs' => $configs
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request )
  {

    $config          = new TwitterHashtagConfig();
    $config->hashtag = $request->input( 'hashtag' );
    $config->enabled = true;
    $config->save();

    return(
      back()
      ->with(
        [
          'flash_success' => 'New hashtag added'
        ]
      )
    );

  }

  /****************************************************************************/

  public function enable ( Request $request, $id )
  {

    $config = TwitterHashtagConfig::find( $id );

    if( isset( $config ) )
    {

      $config->enabled = true;
      $config->save();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Hashtag enabled'
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
            'flash_error' => 'Hashtag not found'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function disable ( Request $request, $id )
  {

    $config = TwitterHashtagConfig::find( $id );

    if( isset( $config ) )
    {

      $config->enabled = false;
      $config->save();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Hashtag disabled'
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
            'flash_error' => 'Hashtag not found'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $id )
  {

    $config = TwitterHashtagConfig::find( $id );

    if( isset( $config ) )
    {

      $config->delete();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Hashtag Deleted'
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
            'flash_error' => 'Hashtag not found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

}
