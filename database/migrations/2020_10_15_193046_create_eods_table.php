<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eod', function (Blueprint $table) {
            $table->id();
            $table->integer('omset');
            $table->integer('profit');
            $table->integer('sell');
            $table->integer('saldo_akhir');
            $table->integer('expense')->default(0);
            $table->integer('total_tf')->default(0);
            $table->integer('admin_tf')->default(0);
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
        Schema::dropIfExists('eod');
    }
}
