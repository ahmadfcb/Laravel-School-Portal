<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFineGenerationDateTimeColumnInStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'students', function ( Blueprint $table ) {
            $table->dateTime( 'fine_generation_date_time' )->nullable()->after( 'fee_generation_date_time' );
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
            $table->dropColumn( 'fine_generation_date_time' );
        } );
    }
}
