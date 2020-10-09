<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordAddPrivilegeStudentAttendanceEdit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::insert( [
            'name' => 'student_attendance_edit',
            'title' => 'Edit Student Attendance'
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Privilege::where( 'name', 'student_attendance_edit' )->delete();
    }
}
