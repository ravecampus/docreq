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
            $table->text('image')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('item_id')->nullable();
            // $table->string('order_number')->nullable();
            $table->string('item_name')->nullable();
            $table->string('description')->nullable();
            $table->text('note')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('price')->nullable();
            // $table->double('total')->nullable();
            $table->integer('status')->nullable();
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
