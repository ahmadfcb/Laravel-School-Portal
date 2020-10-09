<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'student_attendances', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'student_id' );
            $table->unsignedInteger( 'student_attendance_type_id' );
            $table->timestamps();

            $table->foreign( 'student_id' )->references( 'id' )->on( 'students' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
            $table->foreign( 'student_attendance_type_id' )->references( 'id' )->on( 'student_attendance_types' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'student_attendances' );
    }
}
