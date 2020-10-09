<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveBranchIdFromClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'classes', function ( Blueprint $table ) {
            $table->dropForeign( ['branch_id'] );
            $table->dropColumn( 'branch_id' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'classes', function ( Blueprint $table ) {
            $table->unsignedInteger( 'branch_id' );
        } );
    }
}
