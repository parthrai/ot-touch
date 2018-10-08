<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
/**
 *
 *  This Migration Class will build the tables for 
 *  the Twitter Server.  It uses Phirehose Library
 *  and parses the twitter stream based on keywords
 *
 *
 */

class PhirehoseTweetTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {





            Schema::dropIfExists('tweets');

            Schema::create('tweets', function (Blueprint $table) {
                $table->bigInteger('tweet_id')->unsigned()->index();
                $table->string('tweet_text', 160);
                $table->decimal('geo_lat');
                $table->decimal('geo_long');
                $table->bigInteger('user_id');
                $table->string('screen_name', 50);
                $table->string('name', 50);
                $table->string('profile_image_url', 200);
                $table->string('media', 140);
                //todo: remove the is_rt field once we no longer pull in rt's
                $table->tinyInteger('is_rt');
                $table->tinyInteger('is_approved')->default(0);
                $table->timestamps();
            });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tweets');
    }
}
