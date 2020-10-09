<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchClassSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'branch_class_section', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->integer( 'branch_id' )->unsigned();
            $table->unsignedInteger( 'class_id' );
            $table->unsignedInteger( 'section_id' );

            $table->foreign( 'branch_id' )->references( 'id' )->on( 'branches' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
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
        Schema::dropIfExists( 'branch_class_section' );
        Schema::enableForeignKeyConstraints();
    }
}
