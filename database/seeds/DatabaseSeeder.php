<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    $in_continuous_integration = false;
    
    if( getenv('TRAVIS') )
    {
      $in_continuous_integration = true;
    }
    else
    {
      $in_continuous_integration = false;
    }

    // Only run seeders in development and testing environments
    if( App::environment( 'local' ) || App::environment( 'testing' ) )
    {

      $this->call( UsersTableSeeder::class );
      $this->call( ScreenSettingsSeeder::class );
      $this->call( TwitterHashtagConfigSeeder::class );
      
      if( $in_continuous_integration )
      {
        $this->call( ScoreboardTeamConfigTableSeeder::class );
      }

      if( ! $in_continuous_integration )
      {

        $this->call( TweetTableSeeder::class );
        $this->call( PointsTableSeeder::class );

        $this->call( ScoreboardTablesSeeder::class );

      }

    }

  }

  /****************************************************************************/

}
