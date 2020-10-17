<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string("nama_produk",40);
            $table->integer("id_kategori");
            $table->integer("stok");
            $table->integer("harga_modal");
            $table->integer("harga_jual");
            $table->integer("diskon")->nullable();
            $table->string("distributor");
            $table->text("deskripsi")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->string('user')->default("admin");
            $table->tinyInteger('best_seller')->default(0);
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
        Schema::dropIfExists('produk');
    }
}
