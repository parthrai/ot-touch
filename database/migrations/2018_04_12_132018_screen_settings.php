<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScreenSettings extends Migration
{
  /****************************************************************************/

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up ()
  {
    Schema::create(
      'screen_settings',
      function ( Blueprint $table )
      {
        $table->increments( 'id' );
        $table->string( 'screen' );
        $table->boolean( 'status' )->default( true );
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
    Schema::dropIfExists( 'screen_settings' );
  }

  /****************************************************************************/

}
