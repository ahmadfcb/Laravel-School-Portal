<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentFeeTransactionRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists( 'student_fee_transaction_records' );

        Schema::create( 'student_fee_transaction_records', function ( Blueprint $table ) {
            $table->increments( 'id' );

            $table->unsignedInteger( 'student_fee_transaction_id' );
            $table->unsignedInteger( 'student_fee_type_id' );
            $table->unsignedInteger( 'credit' )->default( 0 )->comment( "Liability account. Credit increases the balance" );
            $table->unsignedInteger( 'debit' )->default( 0 )->comment( "Liability account. Debit decreases the balance" );
            $table->integer( 'balance' );

            $table->foreign( 'student_fee_transaction_id', 'std_fee_trans_rec_fee_transac_fkey' )->references( 'id' )->on( 'student_fee_transactions' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
            $table->foreign( 'student_fee_type_id', 'std_fee_trans_rec_str_fee_type_id' )->references( 'id' )->on( 'student_fee_types' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'student_fee_transaction_records' );
    }
}
