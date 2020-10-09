<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'student_performances', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'student_id' );
            $table->date( 'performance_date' );
            $table->unsignedInteger('performance_type_id');
            $table->unsignedInteger( 'performance_scale_id' );
            $table->timestamps();

            $table->unique( ['student_id', 'performance_date'] );
            $table->foreign( 'student_id' )->references( 'id' )->on( 'students' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
            $table->foreign( 'performance_scale_id' )->references( 'id' )->on( 'performance_scales' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'student_performances' );
    }
}
