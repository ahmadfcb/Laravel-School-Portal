<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CanEditExtraDiscount20190202 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::create( [
            'name' => 'can_edit_extra_discount',
            'title' => "Can Edit Student's Extra Discount"
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Privilege::where( 'name', 'can_edit_extra_discount' )->delete();
    }
}
