<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttendanceDateInStudentAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'student_attendances', function ( Blueprint $table ) {
            $table->date( 'attendance_date' )->after( 'student_attendance_type_id' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'student_attendances', function ( Blueprint $table ) {
            $table->dropColumn( 'attendance_date' );
        } );
    }
}
