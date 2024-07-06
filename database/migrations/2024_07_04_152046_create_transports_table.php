<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Transports', function (Blueprint $table) {

            $table->id();
            $table->string('UnitCode')->unique();
            $table->string('Name');
            $table->double('price');
            $table->double('PerCentPrice');
            $table->unsignedInteger('deliveryTime');
            $table->string('AvatarPhoto');
            $table->float('Rate', 8, 2)->default(0.0);
            $table->unsignedInteger('total_ratings')->default(0);
            $table->unsignedInteger('rating_count')->default(0);


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
        Schema::dropIfExists('Transports');
    }
}
