<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentFeeTransactionRelatedPrivileges20190112 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::insert( [
            ['name' => 'student_fee_transaction_view_single', 'title' => 'View/Print student fee transaction'],
            ['name' => 'student_fee_transaction_view_all', 'title' => 'View all fee transactions of students'],
            ['name' => 'student_fee_transaction_delete', 'title' => "Delete student's fee transaction"]
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Privilege::where( 'name', 'student_fee_transaction_view_single' )
            ->orWhere( 'name', 'student_fee_transaction_view_all' )
            ->orWhere( 'name', 'student_fee_transaction_delete' )
            ->delete();
    }
}
