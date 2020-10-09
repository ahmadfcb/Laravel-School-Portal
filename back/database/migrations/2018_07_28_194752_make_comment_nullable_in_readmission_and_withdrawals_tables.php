<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCommentNullableInReadmissionAndWithdrawalsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'readmissions', function ( Blueprint $table ) {
            $table->text( 'comment' )->nullable()->change();
        } );

        Schema::table( 'withdrawals', function ( Blueprint $table ) {
            $table->text( 'comment' )->nullable()->change();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'readmissions', function ( Blueprint $table ) {
            $table->text( 'comment' )->change();
        } );

        Schema::table( 'withdrawals', function ( Blueprint $table ) {
            $table->text( 'comment' )->change();
        } );
    }
}
