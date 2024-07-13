<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRolesTable extends Migration
{
    public function up()
    {
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_roles');
    }
}
