<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToClassTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_test_table', function (Blueprint $table) {
            //
            $table->integer('test_avg');
            $table->string('test_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_test_table', function (Blueprint $table) {
            //
            Schema::drop('class_test_table');
        });
    }
}
