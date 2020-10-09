<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerformanceScalePrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table( 'privileges' )
            ->insert( [
                [
                    'name' => 'performance_scale_view',
                    'title' => 'View Performance Scale'
                ],
                [
                    'name' => 'performance_scale_add',
                    'title' => 'Add new in Performance Scale'
                ],
                [
                    'name' => 'performance_scale_edit',
                    'title' => 'Edit Performance Scale entry'
                ],
                [
                    'name' => 'performance_scale_delete',
                    'title' => 'Delete Performance Scale entry'
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
        DB::table( 'privileges' )
            ->where( [
                ['name' => 'performance_scale_view'],
                ['name' => 'performance_scale_add'],
                ['name' => 'performance_scale_edit'],
                ['name' => 'performance_scale_delete']
            ] )->delete();
    }
}
