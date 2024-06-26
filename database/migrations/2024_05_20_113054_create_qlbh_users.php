<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qlbh_users', function (Blueprint $table) {
            $table->increments('admin_id');
            $table->string('admin_username')->unique();
            $table->string('admin_password');
            $table->string('admin_phone');
            $table->string('admin_role');
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
        Schema::dropIfExists('qlbh_users');
    }
};
