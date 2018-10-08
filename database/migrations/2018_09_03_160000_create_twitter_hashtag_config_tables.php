<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterHashtagConfigTables extends Migration
{

  /****************************************************************************/

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up ()
  {

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'twitter_hashtag_configs',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->string( 'hashtag', 32 )->unique();

        $table->boolean( 'enabled' )->default( true )->index();

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

    Schema::dropIfExists( 'twitter_hashtag_configs' );

  }

  /****************************************************************************/

}
