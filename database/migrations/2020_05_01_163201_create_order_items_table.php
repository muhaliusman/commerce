<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->foreignId('discount_id');
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts');
            $table->tinyInteger('qty')
                ->default(0);
            $table->double('price')
                ->default('0');
            $table->double('discount')
                ->default('0');
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
        Schema::dropIfExists('order_items');
    }
}
