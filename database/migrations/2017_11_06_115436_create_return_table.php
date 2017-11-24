<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_return', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('inv_goods_out_id');
            $table->integer('qty');
            $table->text('notes');
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
        Schema::table('inv_goods_return', function (Blueprint $table) {
            Schema::dropIfExists('inv_goods_return');
        });
    }
}
