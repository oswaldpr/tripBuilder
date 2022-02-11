<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->text('airline');
            $table->text('number');
            $table->text('departure_airport');
            $table->text('departure_time');
            $table->text('arrival_airport');
            $table->text('arrival_time');
            $table->float('price');
            $table->unsignedBigInteger('airline_id');
            $table->foreign('airline_id')->references('id')->on('airlines');
            $table->unsignedBigInteger('departure_airport_id');
            $table->foreign('departure_airport_id')->references('id')->on('airports');
            $table->unsignedBigInteger('arrival_airport_id');
            $table->foreign('arrival_airport_id')->references('id')->on('airports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
};
