<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geo_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->string('operator_code')->nullable();
            $table->integer('country_id')->index()->unsigned();
            $table->foreign('country_id')->references('id')->on('geo_countries')->onDelete('no action');
            $table->integer('touristic_zone_id')->index()->unsigned()->nullable();
            $table->foreign('touristic_zone_id')->references('id')->on('geo_touristic_zones')->onDelete('no action');
            $table->text('short_info')->nullable();
            $table->text('details')->nullable();
            $table->string('feature_image', 191)->nullable();
            $table->string('display_zone')->nullable();
            $table->string('meta')->nullable();
            $table->boolean('active')->default(true);
            $table->string('slug')->index();
            $table->integer('parent_id')->nullable();
            $table->integer('lft')->default(0);
            $table->integer('rgt')->default(0);
            $table->integer('depth')->default(0);
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
        Schema::dropIfExists('geo_cities');
    }
}
