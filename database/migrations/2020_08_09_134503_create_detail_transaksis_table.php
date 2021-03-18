<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer("id_transaksi");
            $table->integer("id_produk")->nullable();
            $table->integer("jumlah");
            $table->integer("total_harga");
            $table->text("deskripsi_transaksi")->nullable();
            $table->integer("id_trx_category")->default(1)->comment("1 = Transaksi kasir, etc parameterize");
            $table->tinyInteger("status")->default(1);
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
        Schema::dropIfExists('detail_transaksi');
    }
}
