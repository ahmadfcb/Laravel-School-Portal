<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordAddStudentAttendanceViewAndStudentAttendanceMarkInPrivilivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('privileges')
            ->insert([
                [
                    'name' => 'student_attendance_view',
                    'title' => 'View Student Attendance'
                ],
                [
                    'name' => 'student_attendance_mark',
                    'title' => 'Mark Student Attendance'
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('privileges')
            ->orWhere([
                ['name' => 'student_attendance_view'],
                ['name' => 'student_attendance_mark']
            ])
            ->delete();
    }
}
