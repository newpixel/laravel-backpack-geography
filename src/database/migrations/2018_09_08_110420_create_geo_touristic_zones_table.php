<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->text('details')->nullable();
            $table->string('feature_image', 191)->nullable();
            $table->string('meta')->nullable();
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
