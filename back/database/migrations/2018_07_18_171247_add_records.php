<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('privileges')
            ->insert([
                [
                    'name' => 'attendance_type_update',
                    'title' => 'Update Attendance Type'
                ],
                [
                    'name' => 'attendance_type_delete',
                    'title' => 'Delete Attendance Type'
                ],
                [
                    'name' => 'modify_options',
                    'title' => 'Modify System Options'
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('privileges')
            ->orWhere([
                ['name' => 'attendance_type_update'],
                ['name' => 'attendance_type_delete'],
                ['name' => 'modify_options']
            ])->delete();
    }
}
