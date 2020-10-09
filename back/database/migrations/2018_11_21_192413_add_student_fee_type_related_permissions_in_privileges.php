<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentFeeTypeRelatedPermissionsInPrivileges extends Migration
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
                'name' => 'student_fee_type_add',
                'title' => 'Add Student Fee Type'
            ],
            [
                'name' => 'student_fee_type_edit',
                'title' => 'Edit Student Fee Type'
            ],
            [
                'name' => 'student_fee_type_delete',
                'title' => 'Delete Student Fee Type'
            ],
            [
                'name' => 'student_fee_type_view',
                'title' => 'View Student Fee Type'
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
        \App\Privilege::orWhere( [
            ['name', '=', 'student_fee_type_add'],
            ['name', '=', 'student_fee_type_edit'],
            ['name', '=', 'student_fee_type_view'],
            ['name', '=', 'student_fee_type_delete']
        ] )->delete();
    }
}
