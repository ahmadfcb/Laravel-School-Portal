<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignKeyToNotDeleteRecords20190122 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'students', function ( Blueprint $table ) {
            // branch foreign key
            $table->dropForeign( 'students_branch_id_foreign' );
            $table->foreign( 'branch_id' )->references( 'id' )->on( 'branches' )->onUpdate( 'cascade' )->onDelete( 'set null' );

            // school medium foreign key
            $table->dropForeign( 'students_school_medium_id_foreign' );
            $table->foreign( 'school_medium_id' )->references( 'id' )->on( 'school_mediums' )->onUpdate( 'cascade' )->onDelete( 'set null' );

            // class of admission foreign key
            $table->dropForeign( 'students_class_of_admission_id_foreign' );
            $table->foreign( 'class_of_admission_id' )->references( 'id' )->on( 'classes' )->onUpdate( 'cascade' )->onDelete( 'set null' );

            // current class foreign key
            $table->dropForeign( 'students_current_class_id_foreign' );
            $table->foreign( 'current_class_id' )->references( 'id' )->on( 'classes' )->onUpdate( 'cascade' )->onDelete( 'set null' );

            // section foreign key
            $table->dropForeign( 'students_section_id_foreign' );
            $table->foreign( 'section_id' )->references( 'id' )->on( 'sections' )->onUpdate( 'cascade' )->onDelete( 'set null' );

            // father record foreign key
            $table->dropForeign( 'students_father_record_id_foreign' );
            $table->foreign( 'father_record_id' )->references( 'id' )->on( 'father_records' )->onUpdate( 'cascade' )->onDelete( 'set null' );

            // category foreign key
            $table->dropForeign( 'students_category_id_foreign' );
            $table->foreign( 'category_id' )->references( 'id' )->on( 'categories' )->onUpdate( 'cascade' )->onDelete( 'set null' );

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'students', function ( Blueprint $table ) {

        } );
    }
}
