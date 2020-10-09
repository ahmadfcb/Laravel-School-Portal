<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAllowFeeGenerateRecordInOption20190117 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Option::create( [
            'name' => 'allow_automatic_fee_generate',
            'value' => '0'
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Option::where( 'name', 'allow_automatic_fee_generate' )->delete();
    }
}
