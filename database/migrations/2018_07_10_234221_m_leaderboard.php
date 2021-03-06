<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MLeaderboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mLeaderboard', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('container');
            $table->string('image');
            $table->integer('orderis');
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
        Schema::dropIfExists('mLeaderboard');
    }
}
