<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('title');
            $table->string('vendor_id');
            $table->string('delivery')->nullable();
            $table->string('shipment_to')->nullable();
            $table->string('freight')->nullable();
            $table->string('insurance')->nullable();
            $table->string('payment')->nullable();
            $table->string('total');
            $table->string('tax');
            $table->string('issued_by');
            $table->integer('status');
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
        Schema::dropIfExists('po');
    }
}
