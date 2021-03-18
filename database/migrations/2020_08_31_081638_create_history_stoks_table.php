<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_stok', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produk')->default(0);
            $table->integer('before');
            $table->integer('add_stok');
            $table->integer('after');
            $table->string('user')->default("admin");
            $table->text('description')->nullable();
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
        Schema::dropIfExists('history_stok');
    }
}
