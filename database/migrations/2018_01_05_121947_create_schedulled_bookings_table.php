<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('message')->nullable()->default(null);
            $table->text('result')->nullable()->default(null);
            $table->string('user')->nullable()->default(null);
            $table->boolean('recurring')->default(false);
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
