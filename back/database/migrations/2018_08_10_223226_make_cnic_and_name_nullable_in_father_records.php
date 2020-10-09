<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCnicAndNameNullableInFatherRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'father_records', function ( Blueprint $table ) {
            $table->string( 'name', 50 )->nullable()->change();
            $table->string( 'cnic', 13 )->nullable()->change();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'father_records', function ( Blueprint $table ) {
            $table->string( 'name', 50 )->change();
            $table->string( 'cnic', 13 )->change();
        } );
    }
}
