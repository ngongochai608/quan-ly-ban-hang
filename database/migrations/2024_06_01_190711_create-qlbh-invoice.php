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
        Schema::create('qlbh_invoice', function (Blueprint $table) {
            $table->increments('invoice_id');
            $table->string('invoice_name');
            $table->string('invoice_table_id');
            $table->string('invoice_info');
            $table->string('invoice_status');
            $table->string('invoice_discount_value');
            $table->string('invoice_discount_type');
            $table->string('invoice_total_price_discount');
            $table->string('invoice_total_price');
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
        Schema::dropIfExists('qlbh_invoice');
    }
};
