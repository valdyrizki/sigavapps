<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer("total_harga");
            $table->integer("balance_before");
            $table->integer("balance_after");
            $table->string('user')->default("admin");
            $table->integer("id_eod")->default(0);
            $table->smallInteger("type")->default(1)->comment("1 = Transaksi kasir, 2 = Pemasukan, 3 = Pengeluaran, 4 = Jasa Transfer (Default 1)");
            $table->text('deskripsi_transaksi')->nullable();
            $table->smallInteger("status")->default(1)->comment("1 = Cash, 2 = Hutang");
            $table->integer("id_member")->default(0)->comment("0 = Default, lainnya dari table member");
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
        Schema::dropIfExists('transaksi');
    }
}
