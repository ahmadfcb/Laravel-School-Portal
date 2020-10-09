<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordAddPrivilegesForCharacterAndLeaveCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::insert( [
            [
                'name' => 'leave_certificate_print',
                'title' => 'Print Leave Certificate'
            ],
            [
                'name' => 'character_certificate_print',
                'title' => 'Print Character Certificate'
            ]
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Privilege::where( 'name', 'leave_certificate_print' )->orWhere( 'name', 'character_certificate_print' )->delete();
    }
}
