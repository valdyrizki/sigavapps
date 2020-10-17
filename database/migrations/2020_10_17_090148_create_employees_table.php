<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->string('firstname',20);
            $table->string('lastname',20);
            $table->date('birthdate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
