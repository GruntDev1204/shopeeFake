<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            
            $table->id();
            $table->unsignedBigInteger('cateGoryKey');
            $table->string('name');
            $table->double('price');
            $table->double('promotionalPrice');
            $table->text('describle');
            $table->longText('DetailedDescrible');
            $table->string('UrlPhoto');
            $table->string('codeProduct')->unique();
            $table->boolean('action');

            $table->foreign('cateGoryKey')
            ->references('id')
            ->on('cate_gories')
            ->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
}
