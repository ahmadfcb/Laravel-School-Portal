<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditFeeFineArrearsMultiple extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::insert([
            'name' => 'edit_fee_fine_arrears_multiple',
            'title' => 'Edit Fee and Fine Arrears for a Student (Mass/Multiple)'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Privilege::where('name', 'edit_fee_fine_arrears_multiple')->delete();
    }
}
