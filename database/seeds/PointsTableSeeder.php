<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\Point;

class PointsTableSeeder extends Seeder
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

    DB::beginTransaction();    

    try
    {
      DB::unprepared( file_get_contents( 'database/raw/points.sql' ) );
      DB::commit();
      $this->command->info( 'Points table seeded!' );
    }
    catch( \Exception $ex )
    {
      DB::rollBack();
      $this->command->info( $ex->getMessage() . "\n" );
    }
    
    Eloquent::reguard();

  }

  /****************************************************************************/

}
