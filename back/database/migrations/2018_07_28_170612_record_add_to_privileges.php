<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordAddToPrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::insert( [
            [
                'name' => 'student_withdraw',
                'title' => 'Withdraw Student'
            ]
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Privilege::where( 'name', 'student_withdraw' )->delete();
    }
}
