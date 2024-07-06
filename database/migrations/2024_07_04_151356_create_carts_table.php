<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->string('codeInvoice')->nullable()->default(null);
            $table->string('codeProduct');
            $table->string('codeCustomer');
            $table->unsignedInteger('QuanitityOfProduct')->default(1);
            $table->double('Price');
            $table->boolean('status')->default(false);


            $table->foreign('codeInvoice')->references('codeInvoices')->on('invoices')->onDelete('set null');

             // Tạo khóa ngoại cho cột codeProduct
            $table->foreign('codeProduct')->references('codeProduct')->on('products')->onDelete('cascade');


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
        Schema::dropIfExists('carts');
    }
}
