<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoTouristicZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_touristic_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->text('full_details')->nullable();
            $table->string('feature_image', 191)->nullable();
            $table->text('meta')->nullable();
            $table->boolean('active')->default(true);
            $table->string('slug')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geo_touristic_zones');
    }
}
