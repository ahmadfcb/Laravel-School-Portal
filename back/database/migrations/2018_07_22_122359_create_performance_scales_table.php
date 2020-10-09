<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformanceScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performance_scales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191)->comment('This can be as: Excellent, Good, Satisfactory etc.');
            $table->tinyInteger('scale_weight')->unsigned()->unique()->comment('i.e. For one star, its value should be one.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performance_scales');
    }
}
