<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\ScoreboardTeamConfig;

class ScoreboardTeamConfigController extends Controller
{

  /****************************************************************************/

  public function index ( Request $request )
  {

    $teams = ScoreboardTeamConfig::orderBy('name')->get();

    return(
      view( 'scoreboard-team-configs.index' )
      ->with(
        [
          'teams' => $teams
        ]
      )
    );

  }

  /****************************************************************************/

  public function create_form ( Request $request )
  {

    $team = new ScoreboardTeamConfig();

    return(
      view( 'scoreboard-team-configs.create' )
      ->with(
        [
          'team' => $team
        ]
      )
    );

  }

  /****************************************************************************/

  public function create ( Request $request )
  {

    $team                       = new ScoreboardTeamConfig();
    $team->name                 = $request->input( 'name' );
    $team->hashtag              = $request->input( 'hashtag' );
    $team->hex_background_color = $request->input( 'hex_background_color' );
    $team->hex_text_color       = $request->input( 'hex_text_color' );
    $team->invisible               = $request->input( 'invisible' );
    $team->save();

    return(
      back()
      ->with(
        [
          'flash_success' => 'New Team Added'
        ]
      )
    );

  }

  /****************************************************************************/

  public function edit ( Request $request, $id )
  {

    $team = ScoreboardTeamConfig::find( $id );

    if( isset( $team ) )
    {

      return(
        view( 'scoreboard-team-configs.update' )
        ->with(
          [
            'team' => $team
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
            'flash_error' => 'Team Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function update ( Request $request, $id )
  {

    $team = ScoreboardTeamConfig::find( $id );

    if( isset( $team ) )
    {

      $team->name                 = $request->input( 'name' );
      $team->hashtag              = $request->input( 'hashtag' );
      $team->hex_background_color = $request->input( 'hex_background_color' );
      $team->hex_text_color       = $request->input( 'hex_text_color' );
      $team->invisible            = $request->input( 'invisible' );
      $team->save();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Team Updated'
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
            'flash_error' => 'Team Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function delete ( Request $request, $id )
  {

    $team = ScoreboardTeamConfig::find( $id );

    if( isset( $team ) )
    {

      $team->delete();

      return(
        back()
        ->with(
          [
            'flash_success' => 'Team Deleted'
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
            'flash_error' => 'Team Not Found!'
          ]
        )
      );

    }

  }

  /****************************************************************************/

  public function reset_teams ( Request $request )
  {
    ScoreboardTeamConfig::ResetToDefaultTeams();
    return(
      back()
      ->with(
        [
          'flash_success' => 'Teams reset to default settings.'
        ]
      )
    );
  }

  /****************************************************************************/

}
