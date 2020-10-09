<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassSectionSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_section_subject', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('class_section_id')->unsigned();
            $table->integer('subject_id')->unsigned();

            $table->foreign('class_section_id')->references('id')->on('class_section')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_section_subject');
    }
}
