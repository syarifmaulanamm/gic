<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_log', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('goods_id');
            $table->boolean('in');
            $table->boolean('out');
            $table->integer('qty');
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
        Schema::table('inv_log', function (Blueprint $table) {
            Schema::dropIfExists('inv_log');
        });
    }
}
