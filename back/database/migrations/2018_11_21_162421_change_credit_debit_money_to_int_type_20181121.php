<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCreditDebitMoneyToIntType20181121 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_fee_transactions', function (Blueprint $table) {
            $table->integer( 'credit' )->default( 0 )->comment( "Adding amount in student's account, which he has to pay." )->change();
            $table->integer( 'debit' )->default( 0 )->comment( "Subtracting ammount from student's account reducing the due fee." )->change();
            $table->integer( 'balance' )->default( 0 )->comment( "Total due balance after this transaction." )->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_fee_transactions', function (Blueprint $table) {
            $table->decimal( 'credit' )->default( 0 )->comment( "Adding amount in student's account, which he has to pay." )->change();
            $table->decimal( 'debit' )->default( 0 )->comment( "Subtracting ammount from student's account reducing the due fee." )->change();
            $table->decimal( 'balance' )->default( 0 )->comment( "Total due balance after this transaction." )->change();
        });
    }
}
