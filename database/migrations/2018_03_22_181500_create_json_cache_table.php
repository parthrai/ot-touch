<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJsonCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('json_cache', function (Blueprint $table) {
            $table->bigInteger('tweet_id');
            $table->increments('cache_id');
            $table->timestamp('cache_date');
            $table->text('raw_tweet');
        

        $table->index('tweet_id');
        $table->index('cache_date');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('json_cache');
    }
}
