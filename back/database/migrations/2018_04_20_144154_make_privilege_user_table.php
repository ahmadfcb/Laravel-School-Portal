<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePrivilegeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'privilege_user', function ( Blueprint $table ) {
            $table->increments( 'id' );
            $table->unsignedInteger( 'user_id' );
            $table->unsignedInteger( 'privilege_id' );

            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
            $table->foreign( 'privilege_id' )->references( 'id' )->on( 'privileges' )->onDelete( 'cascade' )->onUpdate( 'cascade' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'privilege_user' );
    }
}
