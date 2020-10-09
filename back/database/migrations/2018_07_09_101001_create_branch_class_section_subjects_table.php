<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchClassSectionSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'branch_class_section_subjects', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'branch_class_section_id' );
            $table->unsignedInteger( 'subject_id' );

            $table->foreign( 'branch_class_section_id' )->references( 'id' )->on( 'branch_class_section' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
            $table->foreign( 'subject_id' )->references( 'id' )->on( 'subjects' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'branch_class_section_subjects' );
    }
}
