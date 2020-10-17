<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_produk', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produk');
            $table->integer('harga_modal_before');
            $table->integer('harga_jual_before');
            $table->integer('harga_modal_after');
            $table->integer('harga_jual_after');
            $table->string('user')->default("admin");
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
        Schema::dropIfExists('history_produk');
    }
}
