<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('Posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dataId')->unique();
            $table->string('eventId');
            $table->string('uuid');
            $table->string('teamId');
            $table->string('email');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('title');
            $table->string('company');
            $table->string('content');
            $table->bigInteger('created');
            $table->bigInteger('updated');
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
        //
        Schema::dropIfExists('Posts');

    }
}
