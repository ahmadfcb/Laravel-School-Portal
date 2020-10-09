<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeSectionSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'section_subject', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'section_id' );
            $table->unsignedInteger( 'subject_id' );

            $table->foreign( 'section_id' )->references( 'id' )->on( 'sections' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreign( 'subject_id' )->references( 'id' )->on( 'subjects' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
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
        Schema::dropIfExists( 'section_subject' );
        Schema::enableForeignKeyConstraints();
    }
}
