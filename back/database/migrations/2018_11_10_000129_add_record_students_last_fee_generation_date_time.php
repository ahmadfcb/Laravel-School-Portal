<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecordStudentsLastFeeGenerationDateTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Option::create( [
            'name' => 'students_last_fee_generation_date_time',
            'value' => '1980-01-01 00:00:00'
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Option::where( 'name', 'students_last_fee_generation_date_time' )->delete();
    }
}
