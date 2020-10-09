<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignedClassFeeColumnToStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'students', function ( Blueprint $table ) {
            $table->integer( 'assigned_class_fee' )->default( 0 )->after( 'note' );
        } );

        $students = \App\Student::with( ['currentClass'] )->get();
        foreach ( $students as $student ) {
            $student->assigned_class_fee = $student->currentClass->fee ?? 0;
            $student->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'students', function ( Blueprint $table ) {
            $table->dropColumn( 'assigned_class_fee' );
        } );
    }
}
