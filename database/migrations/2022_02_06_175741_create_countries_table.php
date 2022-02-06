<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('iso2', 2)->comment('ISO 3166-1 alpha-2 codes are two-letter country codes defined in ISO 3166-1');
            $table->string('iso3', 3)->comment('ISO 3166-1 alpha-3 codes are three-letter country codes defined in ISO 3166-1');
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
        Schema::dropIfExists('countries');
    }
}
