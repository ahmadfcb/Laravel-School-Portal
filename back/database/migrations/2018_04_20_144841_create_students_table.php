<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'students', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'pin' );
            $table->string( 'reg_no', 50 );
            $table->string( 'session', 50 )->nullable();
            $table->string( 'name', 50 );
            $table->date( 'dob' )->nullable();
            $table->string( 'dob_words', 191 )->nullable();
            $table->string( 'cnic', 13 )->nullable();
            $table->string( 'gender', 6 );
            $table->string( 'religion', 10 )->nullable();
            $table->string( 'caste', 10 )->nullable();
            $table->string( 'blood_group', 10 )->nullable();
            $table->text( 'speciality' )->nullable();
            $table->unsignedInteger( 'school_medium_id' )->nullable();
            $table->unsignedInteger( 'branch_id' )->nullable();
            $table->unsignedInteger( 'class_of_admission_id' )->nullable();
            $table->unsignedInteger( 'current_class_id' )->nullable();
            $table->unsignedInteger( 'section_id' )->nullable();
            $table->date( 'date_of_admission' )->nullable();
            $table->unsignedInteger( 'father_record_id' )->nullable();
            $table->string( 'mother_name', 50 )->nullable();
            $table->text( 'mother_qualification' )->nullable();
            $table->string( 'mother_profession', 191 )->nullable();
            $table->string( 'mother_job_address', 191 )->nullable();
            $table->string( 'mother_phone', 20 )->nullable();
            $table->string( 'home_street_address', 191 )->nullable();
            $table->string( 'city', 50 )->nullable();
            $table->string( 'colony', 50 )->nullable();
            $table->text( 'note' )->nullable();
            $table->boolean( 'withdrawn' )->default( 0 )->comment( '1 for withdrawn 0 for active' );

            $table->foreign( 'school_medium_id' )->references( 'id' )->on( 'school_mediums' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreign( 'branch_id' )->references( 'id' )->on( 'branches' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreign( 'class_of_admission_id' )->references( 'id' )->on( 'classes' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreign( 'current_class_id' )->references( 'id' )->on( 'classes' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreign( 'section_id' )->references( 'id' )->on( 'sections' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
            $table->foreign( 'father_record_id' )->references( 'id' )->on( 'father_records' )->onUpdate( 'cascade' )->onDelete( 'cascade' );
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
        Schema::dropIfExists( 'students' );
        Schema::enableForeignKeyConstraints();
    }
}
