<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeStudentFeeTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists( 'student_fee_transactions' );
        Schema::enableForeignKeyConstraints();

        Schema::create( 'student_fee_transactions', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'student_id' );
            $table->unsignedInteger( 'student_fee_type_id' );
            $table->unsignedInteger( 'credit' )->default( 0 )->comment( "Liability account. Credit increases the balance" );
            $table->unsignedInteger( 'debit' )->default( 0 )->comment( "Liability account. Debit decreases the balance" );
            $table->integer( 'balance' );
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('student_fee_type_id')->references('id')->on('student_fee_types')->onDelete('cascade')->onUpdate('cascade');
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop( 'student_fee_transactions' );
    }
}
