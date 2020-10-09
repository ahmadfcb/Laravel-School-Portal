<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueKeyInStudentAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'student_attendances', function ( Blueprint $table ) {
            $table->unique( ['student_id', 'attendance_date'] );
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
            $table->dropUnique( ['student_id', 'attendance_date'] );
        } );
    }
}
