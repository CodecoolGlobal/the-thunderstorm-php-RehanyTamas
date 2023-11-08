<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->float('temperature_celsius');
            $table->float('precipitation_millimeter');
            $table->float('humidity_percent');
            $table->float('wind_speed');
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
        Schema::dropIfExists('weather_data');
    }
}
