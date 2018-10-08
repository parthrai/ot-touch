<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\Tweets;

class TweetTableSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    Eloquent::unguard();

    $path = 'database/raw/tweets.sql';

    try
    {
      DB::unprepared( file_get_contents( $path ) );
    }
    catch ( Exception $e )
    {
      $this->command->info( $e );
      die();
    }

    $this->command->info( 'Tweets table seeded!' );

    Eloquent::reguard();

  }

  /****************************************************************************/

}
