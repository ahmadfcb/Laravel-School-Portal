<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrivilegeCanEditStudentFeeFine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::insert( [
            'name' => 'edit_fee_fine_arrears',
            'title' => 'Edit Fee and Fine Arrears for a Student'
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Privilege::where( 'name', 'edit_fee_fine_arrears' )->delete();
    }
}
