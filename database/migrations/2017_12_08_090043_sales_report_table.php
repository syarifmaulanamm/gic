<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_type');
            $table->string('sales_client_id');
            $table->string('subject');
            $table->string('gross');
            $table->string('netto');
            $table->string('profit');
            $table->date('month');            
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
        Schema::dropIfExists('sales_report');
    }
}
