<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateLeaderboardsTable extends Migration
{

  /****************************************************************************/

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up ()
  {

    Schema::dropIfExists( 'leaderboard' );
    Schema::dropIfExists( 'mLeaderboard' );
    
    Schema::create(
      'leaderboards',
      function ( Blueprint $table )
      {
        $table->increments( 'id' );
        $table->string( 'description', 255 )->index();
        $table->string( 'image_xs', 255 )->nullable();
        $table->string( 'image_sm', 255 )->nullable();
        $table->string( 'image_md', 255 )->nullable();
        $table->string( 'image_lg', 255 )->nullable();
        $table->integer( 'orderis' )->index();
        $table->timestamps();
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

    Schema::create(
      'leaderboard',
      function ( Blueprint $table )
      {
        $table->increments( 'id' );
        $table->string( 'description' );
        $table->string( 'container' );
        $table->string( 'image' );
        $table->integer( 'orderis' );
        $table->timestamps();
      }
    );

    Schema::create(
      'mLeaderboard',
      function ( Blueprint $table )
      {
        $table->increments( 'id' );
        $table->string( 'description' );
        $table->string( 'container' );
        $table->string( 'image' );
        $table->integer( 'orderis' );
        $table->timestamps();
      }
    );

    Schema::dropIfExists( 'leaderboards' );

  }

  /****************************************************************************/

}
