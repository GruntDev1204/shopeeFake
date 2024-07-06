<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Ware_houses', function (Blueprint $table) {
            $table->id();
            $table->string('codeProduct');
            $table->unsignedInteger('QuanTity');
            $table->double('TotalPrice');
            $table->timestamps();

            $table->foreign('codeProduct')
            ->references('codeProduct')
            ->on('products')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Ware_houses');
    }
}
