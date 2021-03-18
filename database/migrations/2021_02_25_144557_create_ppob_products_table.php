<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpobProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_products', function (Blueprint $table) {
            $table->id();
            $table->string("category_id",20);
            $table->string("category_name",30);
            $table->string("operator_id",20);
            $table->string("operator_name",50);
            $table->string("product_id",20);
            $table->string("product_name",50);
            $table->text("product_detail")->nullable();
            $table->string("product_syarat")->nullable();
            $table->string("product_zona")->nullable();
            $table->integer("product_price");
            $table->integer("product_price_sell")->default(0);
            $table->string("product_name_sell")->nullable();
            $table->text("product_detail_sell")->nullable();
            $table->string("product_multi",10);
            $table->string("status",15);
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
        Schema::dropIfExists('ppob_products');
    }
}
