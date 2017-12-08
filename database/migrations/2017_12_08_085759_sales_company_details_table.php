<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesCompanyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_company_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sales_client_id');
            $table->string('pic');
            $table->string('title');
            $table->date('date_of_birth');
            $table->date('date_of_join');
            $table->string('phone');
            $table->string('ext');
            $table->text('other_information');
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
        Schema::dropIfExists('sales_company_details');
    }
}
