<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_categories', function (Blueprint $table) {
            $table->id();
            $table->string("category_name",50);
            $table->smallInteger("type")->default(1)->comment("1 = pemasukan, 2 = pengeluaran");
            $table->text("description")->nullable();
            $table->smallInteger("status")->default(1);
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
        Schema::dropIfExists('trx_categories');
    }
}
