<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordsPerformanceTypePrivileges extends Migration
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
                    'name' => 'performance_type_view',
                    'title' => 'View Performance Types'
                ],
                [
                    'name' => 'performance_type_add',
                    'title' => 'Add New Performance Types'
                ],
                [
                    'name' => 'performance_type_update',
                    'title' => 'Update Performance Types'
                ],
                [
                    'name' => 'performance_type_delete',
                    'title' => 'Delete Performance Types'
                ],
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
            ->orWhere( [
                ['name', '=', 'performance_type_view'],
                ['name', '=', 'performance_type_add'],
                ['name', '=', 'performance_type_update'],
                ['name', '=', 'performance_type_delete']
            ] )->delete();
    }
}
