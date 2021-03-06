<?php

// Author: jholland@opentext.com

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialCardTables extends Migration
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
      'social_card_hashtags',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->string( 'hashtag_text' )->index();

        $table->softDeletes();
        $table->timestamps();

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'social_card_lookups',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'social_card_id' )->unsigned()->index(); // A polymorphic relation to tweets, posts, etc...
        $table->string( 'social_card_type' )->index();             // A polymorphic relation to tweets, posts, etc...

        $table->boolean( 'approved' )->default( false )->index(); // Toggle to approve/disapprove card
        $table->boolean( 'featured' )->default( false )->index(); // Toggle to make this card a featured card

        $table->softDeletes();
        $table->timestamps();

      }
    );

    Schema::table(
      'social_card_lookups',
      function ( Blueprint $table )
      {

        $table->unique( [ 'social_card_id', 'social_card_type' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'social_card_hashtag_lookups',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->integer( 'card_id' )->unsigned()->nullable()->index();
        $table->foreign( 'card_id' )->references( 'id' )->on( 'social_card_lookups' )->onDelete('cascade');

        $table->integer( 'hashtag_id' )->unsigned()->nullable()->index();
        $table->foreign( 'hashtag_id' )->references( 'id' )->on( 'social_card_hashtags' )->onDelete('cascade');

        $table->softDeletes();
        $table->timestamps();

      }
    );

    Schema::table(
      'social_card_hashtag_lookups',
      function ( Blueprint $table )
      {

        $table->unique( [ 'card_id', 'hashtag_id' ] );

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'social_card_tweets',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->dateTime( 'card_created_at' )->index();

        $table->string( 'tweet_id' )->unique();
        $table->string( 'tweet_text', 1024 );

        $table->string( 'lang', 8 )->default('en')->index();

        $table->string( 'user_name' )->index();
        $table->string( 'user_screen_name' )->index();
        $table->string( 'user_location' )->nullable()->index();
        $table->string( 'user_url', 1024 )->nullable();
        $table->string( 'user_image', 1024 )->nullable();

        $table->string( 'image', 1024 )->nullable();

        $table->softDeletes();
        $table->timestamps();

      }
    );

    /** -------------------------------------------------------------------- **/

    Schema::create(
      'social_card_posts',
      function ( Blueprint $table )
      {

        $table->increments( 'id' );

        $table->dateTime( 'card_created_at' )->index();

        $table->string( 'post_id' )->unique();
        $table->string( 'post_text' )->index();

        $table->string( 'lang', 2 )->default('en')->index();

        $table->string( 'first_name' )->nullable()->index();
        $table->string( 'last_name' )->nullable()->index();
        $table->string( 'title' )->nullable()->index();
        $table->string( 'company' )->nullable()->index();
        $table->string( 'profile_photo' )->nullable()->index();
        $table->string( 'appworks_event_id' )->nullable()->index();
        $table->string( 'game_team_uuid' )->nullable()->index();
        $table->string( 'image', 1024 )->nullable();

        $table->softDeletes();
        $table->timestamps();

      }
    );

    /** -------------------------------------------------------------------- **/

  }

  /****************************************************************************/

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down ()
  {

    Schema::dropIfExists( 'social_card_hashtag_lookups' );

    Schema::dropIfExists( 'social_card_posts' );
    Schema::dropIfExists( 'social_card_tweets' );

    Schema::dropIfExists( 'social_card_lookups' );

    Schema::dropIfExists( 'social_card_hashtags' );

  }

  /****************************************************************************/

}
