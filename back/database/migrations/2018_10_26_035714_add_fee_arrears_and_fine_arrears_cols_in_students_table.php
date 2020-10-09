<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeeArrearsAndFineArrearsColsInStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'students', function ( Blueprint $table ) {
            $table->integer( 'total_fee_arrears' )->default(0)->after( 'note' );
            $table->integer( 'total_fine_arrears' )->default(0)->after( 'total_fee_arrears' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'students', function ( Blueprint $table ) {
            $table->dropColumn( ['fee_arrears', 'fine_arrears'] );
        } );
    }
}
