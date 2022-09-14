<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('b_place')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('academic_program')->nullable();
            $table->string('current_enrolled')->nullable();
            $table->year('year_graduated')->nullable();
            $table->year('last_sy')->nullable();
            $table->date('b_date')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('role')->default(0);
            $table->integer('is_active')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('password');
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
}
