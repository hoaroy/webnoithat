<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->string('product_slug')->unique();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('category')->onUpdate('cascade')->onDelete('cascade');
            $table->string('product_desc');
            $table->bigInteger('product_price');
            $table->bigInteger('product_price_sale');
            $table->integer('product_quantity');
            $table->integer('product_view');
            $table->integer('product_sold');
            $table->tinyInteger('product_status',0);
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
        Schema::dropIfExists('product');
    }
}
