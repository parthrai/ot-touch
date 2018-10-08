<?php

namespace App\Http\Controllers\SocialWall;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\ScreenSetting;
use App\ScoreboardTeam;

class SocialWallController extends Controller
{

  /****************************************************************************/

  /**
  * Show social wall page.
  *
  * @return \Illuminate\Http\Response
  */
  public function index ( Request $request )
  {

    $screen_settings = ScreenSetting::pluck( 'status', 'screen' )->toArray();
    $teams           = new ScoreboardTeam();
    $team_sets       = $teams->GetTeamSets( 2 ); // Get n sets of team names and hashtags

    return(
      view(
        'social-wall.index',
        [
          'screen_settings' => $screen_settings,
          'team_sets'       => $team_sets
        ]
      )
    );

  }

  /****************************************************************************/

}
