<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvGoodsOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods_out', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('goods_id');
            $table->boolean('borrow');
            $table->string('pic');
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
        Schema::table('inv_goods_out', function (Blueprint $table) {
            Schema::dropIfExists('inv_goods_out');
        });
    }
}
