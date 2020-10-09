<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameColumnInSmsTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'sms_templates', function ( Blueprint $table ) {
            $table->string( 'name', 191 )->nullable()->after( 'id' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'sms_templates', function ( Blueprint $table ) {
            $table->dropColumn( 'name' );
        } );
    }
}
