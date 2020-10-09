<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentFeeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'student_fee_transactions', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'student_id' );
            $table->string( 'description', 255 )->nullable();
            $table->decimal( 'credit' )->default( 0 )->comment( "Adding amount in student's account, which he has to pay." );
            $table->decimal( 'debit' )->default( 0 )->comment( "Subtracting ammount from student's account reducing the due fee." );
            $table->decimal( 'balance' )->default( 0 )->comment( "Total due balance after this transaction." );
            $table->timestamps();

            $table->foreign( 'student_id' )->references( 'id' )->on( 'students' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'student_fee_transactions' );
    }
}
