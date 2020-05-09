<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('delivery_address');
            $table->string('customer_name');
            $table->string('customer_phone');
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
        Schema::dropIfExists('delivery_info');
    }
}
