<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFeeAndFineArrearColumnsFromStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'students', function ( Blueprint $table ) {
            $table->dropColumn( ['total_fee_arrears', 'total_fine_arrears'] );
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
            $table->integer( 'total_fee_arrears' )->default(0)->after( 'note' );
            $table->integer( 'total_fine_arrears' )->default(0)->after( 'total_fee_arrears' );
        } );
    }
}
