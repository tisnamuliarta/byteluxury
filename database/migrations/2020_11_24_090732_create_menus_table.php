<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('U_MENU', function (Blueprint $table) {
            $table->bigIncrements("ID");
            $table->string("MenuName");
            $table->unsignedBigInteger("CreatedBy");
            $table->dateTime("CreatedAt");
            $table->dateTime("UpdatedAt")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('U_MENU');
    }
}
