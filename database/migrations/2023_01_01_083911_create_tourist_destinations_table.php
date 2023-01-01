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
        Schema::create('tourist_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_district_id')->constrained();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('address', 255);
            $table->string('manager', 255);
            $table->longText('description');
            $table->string('distance_from_city_center', 10);
            $table->longText('transportation_access');
            $table->longText('facility');
            $table->string('latitude', 50);
            $table->string('longitude', 50);
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
        Schema::dropIfExists('tourist_destinations');
    }
};
