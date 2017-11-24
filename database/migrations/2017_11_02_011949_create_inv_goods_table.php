<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_goods', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name');
            $table->text('specification');
            $table->string('price');
            $table->integer('stock');
            $table->boolean('in_stock');
            $table->string('condition');
            $table->text('notes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inv_goods', function (Blueprint $table) {
            Schema::dropIfExists('inv_goods');
        });
    }
}
