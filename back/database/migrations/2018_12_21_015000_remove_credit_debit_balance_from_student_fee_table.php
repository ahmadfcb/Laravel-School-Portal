<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCreditDebitBalanceFromStudentFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'student_fee_transactions', function ( Blueprint $table ) {
            $table->dropForeign( 'student_fee_transactions_student_fee_type_id_foreign' );
            $table->dropColumn( ['student_fee_type_id', 'credit', 'debit', 'balance'] );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'student_fee_transactions', function ( Blueprint $table ) {
            $table->unsignedInteger( 'student_fee_type_id' );
            $table->unsignedInteger( 'credit' )->default( 0 )->comment( "Liability account. Credit increases the balance" );
            $table->unsignedInteger( 'debit' )->default( 0 )->comment( "Liability account. Debit decreases the balance" );
            $table->integer( 'balance' );
        } );
    }
}
