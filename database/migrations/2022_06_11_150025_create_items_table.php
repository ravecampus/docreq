<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->text('image')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('category_id')->nullable();
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->integer('request_limit')->nullable();
            $table->double('price')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('deleted')->default(0);
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
        Schema::dropIfExists('items');
    }
}
