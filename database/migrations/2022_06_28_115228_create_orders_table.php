<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('full_name')->nullable();
            $table->string('mobile_number')->nullable();
            $table->text('delivery_address')->nullable();
            $table->integer('delivery_option')->nullable();
            $table->string('email')->nullable();
            $table->string('trucking_number')->nullable();
            // $table->string('other_info')->nullable();
            $table->double('delivery_fee')->nullable();
            $table->double('total')->nullable();
            $table->double('grand_total')->nullable();
            $table->date('date_received')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
