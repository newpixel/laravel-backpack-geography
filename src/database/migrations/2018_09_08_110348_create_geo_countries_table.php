<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->integer('continent_id')->index()->unsigned();
            $table->foreign('continent_id')->references('id')->on('geo_continents')->onDelete('no action');
            $table->string('operator_code')->nullable();
            $table->text('details')->nullable();
            $table->string('feature_image', 191)->nullable();
            $table->string('display_zone')->nullable();
            $table->string('meta')->nullable();
            $table->boolean('show_on_homepage')->default(false);
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
        Schema::dropIfExists('geo_countries');
    }
}
