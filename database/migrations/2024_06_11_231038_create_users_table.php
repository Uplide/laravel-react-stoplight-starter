<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('phone_code')->nullable();
            $table->date('birthday')->nullable();
            $table->string('image')->default(env("APP_URL") . "/media/users/empty-profile.jpg");
            $table->integer('role')->default(1)->comment("1-User,2-Mod,3-Observer");
            $table->integer('user_total_answer')->default(0);
            $table->enum('gender', ['MALE', 'FEMALE', 'NOT_SPECIFIED'])->nullable();

            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade');
            $table->foreignId('town_id')->nullable()->constrained('towns')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
