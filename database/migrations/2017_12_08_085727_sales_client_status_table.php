<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesClientStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_client_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('classification');
            $table->string('name_of_company');
            $table->string('kind_of_business');
            $table->string('bank_account');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('website');
            $table->text('address');
            $table->string('other_office_location');
            $table->string('number_of_employee');
            $table->string('date_of_assign');
            $table->string('sales_rep');
            $table->string('manager');
            $table->text('remarks');
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
        Schema::dropIfExists('sales_client_status');
    }
}
