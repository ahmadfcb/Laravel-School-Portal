<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordsStudentPerformanceIntoPrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table( 'privileges' )
            ->insert( [
                [
                    'name' => 'student_performance_mark',
                    'title' => 'View Student Performance'
                ],
                [
                    'name' => 'student_performance_report',
                    'title' => 'Student Performance Report'
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
        DB::table( 'privileges' )
            ->where( 'name', 'student_performance_mark' )
            ->orWhere( 'name', 'student_performance_mark' )
            ->delete();
    }
}
