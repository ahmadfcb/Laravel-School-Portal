<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttendanceTypeAddAndAttendanceTypeViewPrivilegesInPrivilegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        \DB::table( 'privileges' )
            ->insert( [
                ['name' => 'attendance_type_view', 'title' => 'View Attendance Types'],
                ['name' => 'attendance_type_add', 'title' => 'Add Attendance Types']
            ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        \DB::table( 'privileges' )
            ->orWhere( [
                ['name' => 'attendance_type_view'],
                ['name' => 'attendance_type_add']
            ] )->delete();
    }
}
