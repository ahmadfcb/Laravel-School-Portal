<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemissionColumnInTransactionRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'student_fee_transaction_records', function ( Blueprint $table ) {
            $table->unsignedInteger( 'remission' )->default( 0 )->after( 'debit' )->comment( "Remission decreases balance." );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'student_fee_transaction_records', function ( Blueprint $table ) {
            $table->dropColumn( 'remission' );
        } );
    }
}
