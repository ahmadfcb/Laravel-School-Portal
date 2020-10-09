<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiblingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'siblings', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->string( 'name', 50 );
            $table->string( 'cnic', 13 )->nullable();
            $table->string( 'class', 50 )->nullable();
            $table->string( 'school', 191 )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'siblings' );
    }
}
