<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeNameInPrivilegesTableUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'privileges', function ( Blueprint $table ) {
            $table->unique( 'name' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'privileges', function ( Blueprint $table ) {
            $table->dropUnique( ['name'] );
        } );
    }
}
