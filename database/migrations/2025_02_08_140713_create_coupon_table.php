<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->id('coupon_id');
            $table->string('coupon_code',50);
            $table->integer('coupon_qty');
            $table->string('coupon_date_start',100);
            $table->string('coupon_date_end',100);
            $table->string('coupon_used',100)->nullable();
            $table->integer('coupon_condition');
            $table->integer('coupon_sale_number');
            $table->tinyInteger('coupon_status',0);
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
        Schema::dropIfExists('coupon');
    }
}
