<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerformanceTypeIdForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'student_performances', function ( Blueprint $table ) {
            $table->foreign( 'performance_type_id' )->references( 'id' )->on( 'performance_types' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'student_performances', function ( Blueprint $table ) {
            $table->dropForeign( ['performance_type_id'] );
        } );
    }
}
