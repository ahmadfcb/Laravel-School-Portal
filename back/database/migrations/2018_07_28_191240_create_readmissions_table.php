<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReadmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'readmissions', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'student_id' );
            $table->text( 'comment' );
            $table->timestamps();

            $table->foreign( 'student_id' )->references( 'id' )->on( 'students' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'readmissions' );
    }
}
