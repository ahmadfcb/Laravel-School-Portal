<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecordAddPrintSheetPrivilege extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Privilege::insert( [
            [
                'name' => 'print_sheet_columns_view',
                'title' => 'Print Sheet Columns View'
            ],
            [
                'name' => 'print_sheet_columns_add',
                'title' => 'Print Sheet Columns Add'
            ],
            [
                'name' => 'print_sheet_columns_edit',
                'title' => 'Print Sheet Columns Edit'
            ],
            [
                'name' => 'print_sheet_columns_delete',
                'title' => 'Print Sheet Columns Delete'
            ],
            [
                'name' => 'print_sheet',
                'title' => 'Print Sheet'
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
        \App\Privilege::where( [
            ['name', '=', 'print_sheet_columns_view'],
            ['name', '=', 'print_sheet_columns_add'],
            ['name', '=', 'print_sheet_columns_edit'],
            ['name', '=', 'print_sheet_columns_delete'],
            ['name', '=', 'print_sheet']
        ] )->delete();
    }
}
