<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueKeyInBranchClassSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'branch_class_section', function ( Blueprint $table ) {
            $table->unique( [
                'branch_id',
                'class_id',
                'section_id'
            ] );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'branch_class_section', function ( Blueprint $table ) {
            $table->dropUnique( [
                'branch_id',
                'class_id',
                'section_id'
            ] );
        } );
    }
}
