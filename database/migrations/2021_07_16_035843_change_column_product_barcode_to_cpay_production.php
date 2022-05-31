<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnProductBarcodeToCpayProduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cpay_production', function (Blueprint $table) {
            if(schema::hasColumn('cpay_production','PRODUCT_BARCODE')){
                $table->string('PRODUCT_BARCODE')->unique()->change();
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpay_production', function (Blueprint $table) {
            //
        });
    }
}
