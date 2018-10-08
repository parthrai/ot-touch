<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPointsTableAddIndexes extends Migration
{

  /****************************************************************************/

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up ()
  {

    Schema::table(
      'points',
      function ( Blueprint $table )
      {
        $table->index( [ 'team' ] );
        $table->index( [ 'points' ] );
        $table->index( [ 'audit' ] );
        $table->index( [ 'source' ] );
      }
    );

  }

  /****************************************************************************/

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down ()
  {

    Schema::table(
      'points',
      function ( Blueprint $table )
      {
        $table->dropIndex( [ 'team' ] );
        $table->dropIndex( [ 'points' ] );
        $table->dropIndex( [ 'audit' ] );
        $table->dropIndex( [ 'source' ] );
      }
    );

  }

  /****************************************************************************/

}
