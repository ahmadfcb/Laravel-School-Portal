<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeeSubDueDateNdFeeFineAfterDueDateToOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Option::insert( [
            [
                'name' => 'fee_submission_due_date',
                'value' => '10'
            ],
            [
                'name' => 'fee_fine_after_due_date',
                'value' => '0'
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
        \App\Option::orWhere( [
            ['name', '=', 'fee_submission_due_date'],
            ['name', '=', 'fee_fine_after_due_date']
        ] )->delete();
    }
}
