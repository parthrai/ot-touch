<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\ScoreboardTeamConfig;

class ScoreboardSetDefaultTeamConfigs extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-scoreboard:set-default-team-configs';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Set default values in scoreboard_team_configs table.';

  /****************************************************************************/

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct ()
  {
    parent::__construct ();
  }

  /****************************************************************************/

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function handle ()
  {

    if( $this->confirm( "Are you sure you want to reset the team configurations to their defaults?\nTHIS CANNOT BE UNDONE." ) )
    {
      ScoreboardTeamConfig::ResetToDefaultTeams();
    }

  }

  /****************************************************************************/

}
