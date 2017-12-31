<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulledBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('schedulled_bookings');
        Schema::create('schedulled_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->string('time');
            $table->string('booker');
            $table->string('room');
            $table->string('message')->nullable()->default(NULL);
            $table->text('result')->nullable()->default(NULL);
            $table->string('user')->nullable()->default(NULL);                
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
        Schema::dropIfExists('schedulled_bookings');
    }
}
