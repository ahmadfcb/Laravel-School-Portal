<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovingPreviousUniqueKeyAndAddingNewWithMultipleColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table( 'student_performances', function ( Blueprint $table ) {
            $table->dropUnique( ['student_id', 'performance_date'] );

            $table->unique( ['student_id', 'performance_date', 'performance_type_id'], 'std_pdate_ptype_unique' );
        } );
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table( 'student_performances', function ( Blueprint $table ) {
            $table->dropUnique( 'std_pdate_ptype_unique' );

            $table->unique( ['student_id', 'performance_date'] );
        } );
        Schema::enableForeignKeyConstraints();
    }
}
