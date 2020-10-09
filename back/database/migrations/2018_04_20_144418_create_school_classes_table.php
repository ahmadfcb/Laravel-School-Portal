<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'classes', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'branch_id' );
            $table->string( 'name' );
            $table->unsignedInteger( 'fee' )->default( 0 );

            $table->foreign( 'branch_id' )->references( 'id' )->on( 'branches' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'classes' );
    }
}
