<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeClassSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'class_section', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'class_id' );
            $table->unsignedInteger( 'section_id' );

            $table->foreign( 'class_id' )->references( 'id' )->on( 'classes' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
            $table->foreign( 'section_id' )->references( 'id' )->on( 'sections' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists( 'class_section' );
        Schema::enableForeignKeyConstraints();
    }
}
