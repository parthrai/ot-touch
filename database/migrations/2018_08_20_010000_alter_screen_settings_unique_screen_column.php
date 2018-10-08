<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterScreenSettingsUniqueScreenColumn extends Migration
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
      'screen_settings',
      function ( Blueprint $table )
      {
        $table->unique( 'screen' );
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
      'screen_settings',
      function ( Blueprint $table )
      {
        $table->dropUnique( [ 'screen' ] );
      }
    );
  }

  /****************************************************************************/

}
