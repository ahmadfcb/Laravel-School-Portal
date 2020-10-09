<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFatherRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'father_records', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'name', 50 );
            $table->string( 'cnic', 13 );
            $table->text( 'qualification' )->nullable();
            $table->string( 'profession', 191 )->nullable();
            $table->string( 'job_address', 191 )->nullable();
            $table->string( 'mobile', 20 )->nullable();
            $table->string( 'sms_cell', 20 )->nullable();
            $table->string( 'ptcl' )->nullable();
            $table->string( 'email', 50 )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'father_records' );
    }
}
