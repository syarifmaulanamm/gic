<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvGoodsInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_in', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('goods_id');
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
        Schema::table('inv_goods_in', function (Blueprint $table) {
            Schema::dropIfExists('inv_goods_in');
        });
    }
}
