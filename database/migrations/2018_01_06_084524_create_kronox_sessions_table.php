<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKronoxSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('kronox_sessions');
        Schema::create('kronox_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('JSESSIONID');
            $table->string('MdhUsername');
            $table->boolean('sessionActive');
            $table->string('user'); // User of this app who "owns" the session
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
        Schema::dropIfExists('kronox_sessions');
    }
}
