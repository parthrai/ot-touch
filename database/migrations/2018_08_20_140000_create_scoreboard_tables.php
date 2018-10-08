<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreboardTables extends Migration
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
      'scoreboard_team_configs',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->string( 'name', 128 )->unique();
        $table->string( 'hashtag', 32 )->unique();

        $table->string( 'hex_background_color', 7 )->default( "#000000" );
        $table->string( 'hex_text_color', 7 )->default( "#FFFFFF" );

        $table->boolean( 'invisible' )->default( false )->index();

        $table->softDeletes();
        $table->timestamps();

      }
    );

    Schema::table(
      'scoreboard_team_configs',
      function ( Blueprint $table )
      {

        $table->unique( [ 'name', 'hashtag' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'scoreboard_teams',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->string( 'team_name' )->unique();

        $table->bigInteger( 'points' )->default(0)->index();
        $table->bigInteger( 'points_aggregate' )->default(0)->index();

        $table->softDeletes();
        $table->timestamps();

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'scoreboard_members',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'team_id' )->unsigned()->nullable()->index();
        $table->foreign( 'team_id' )->references( 'id' )->on( 'scoreboard_teams' );

        $table->string( 'member_name' )->index();
        $table->bigInteger( 'points' )->default(0)->index();

        $table->softDeletes();
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

    Schema::dropIfExists( 'scoreboard_members' );

    Schema::dropIfExists( 'scoreboard_teams' );

    Schema::dropIfExists( 'scoreboard_team_configs' );

  }

  /****************************************************************************/

}
