<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_address', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            // $table->string('fullname')->nullable();
            // $table->string('mobile_number')->nullable();
            // $table->text('note')->nullable();
            $table->string('street')->nullable();
            $table->string('province')->nullable();
            $table->string('city_or_municipality')->nullable();
            $table->string('barangay')->nullable();
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
        Schema::dropIfExists('book_address');
    }
}
