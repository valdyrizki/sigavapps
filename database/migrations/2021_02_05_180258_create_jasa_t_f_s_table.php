<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJasaTFSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa_tf', function (Blueprint $table) {
            $table->id();
            $table->string("norek",50);
            $table->string("an",50);
            $table->string("bank",15)->default("BCA");
            $table->integer("jumlah");
            $table->integer("id_biaya_admin");
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
        Schema::dropIfExists('jasa_tf');
    }
}
