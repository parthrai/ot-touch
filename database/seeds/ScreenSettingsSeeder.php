<?php

use Illuminate\Database\Seeder;

use App\ScreenSetting;

class ScreenSettingsSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    $screens = array(
      'countdown',
      'splash_screen',
      'team_ranking',
      'individual_ranking',
      'red_ranking',
      'blue_ranking',
      'purple_ranking',
      'teal_ranking',
      'grey_ranking',
      'tweets_wall',
      'leaderboards'
    );

    DB::beginTransaction();    
    ScreenSetting::whereNotNull('id')->forceDelete();
    DB::commit();

    foreach( $screens as $screen )
    {

      DB::beginTransaction();

      try
      {

        $setting         = new ScreenSetting();
        $setting->screen = $screen;
        $setting->status = 1;
        $setting->save();

        DB::commit();

      }
      catch( \Exception $ex )
      {

        DB::rollBack();

        $this->command->info( $ex->getMessage() . "\n" );

      }

    }

  }

  /****************************************************************************/

}
