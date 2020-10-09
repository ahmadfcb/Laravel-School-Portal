<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStaticLoadingImagePathInDb20180106 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Option::insert( [
            'name' => 'loading_image_path',
            'value' => 'img/loading-icon.png'
        ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Option::where( 'name', 'loading_image_path' )->delete();
    }
}
