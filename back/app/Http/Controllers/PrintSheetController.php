<?php

namespace App\Http\Controllers;

use App\Branch;
use App\PrintSheetColumn;
use App\SchoolClass;
use App\Section;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintSheetController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:print_sheet_columns_view' )->only( ['index', 'add', 'delete'] );
        $this->middleware( 'CheckPrivilege:print_sheet_columns_delete' )->only( 'delete' );
        $this->middleware( 'CheckPrivilege:print_sheet' )->only( ['printSheetView', 'printSheetPrint'] );
    }

    public function index( PrintSheetColumn $printSheetColumnEdit )
    {
        $title = "Print Sheet Columns";

        $printSheetColumns = PrintSheetColumn::orderBy( 'name' )->get();

        return view( 'print_sheet.index', compact(
            'title',
            'printSheetColumns',
            'printSheetColumnEdit'
        ) );
    }

    public function add( Request $request, PrintSheetColumn $printSheetColumnEdit )
    {
        $this->validate( $request, [
            'name' => 'required|string'
        ] );

        $name = $request->name;

        // if category edit is given. Update record
        if ( $printSheetColumnEdit->id !== null ) {

            if ( !\Auth::user()->userHasPrivilege( 'print_sheet_columns_edit' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            $printSheetColumnEdit->name = $name;
            $printSheetColumnEdit->save();
            return redirect()->route( 'dashboard.print_sheet' )->with( 'msg', "Print Sheet Column updated" );
        } else { // create new

            if ( !\Auth::user()->userHasPrivilege( 'print_sheet_columns_add' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            PrintSheetColumn::create( ['name' => $name] );
            return back()->with( 'msg', "Print Sheet Column has been created." );
        }
    }

    public function delete( PrintSheetColumn $printSheetColumn )
    {
        $printSheetColumn->delete();
        return back()->with( 'msg', "Print Sheet Column deleted successfully!" );
    }

    public function printSheetView( Request $request )
    {
        $title = "Print Sheet";

        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();

        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $section_id = $request->section_id;

        $printSheetColumns = PrintSheetColumn::get();

        return view( 'print_sheet.print_sheet_view', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'current_class_id',
            'section_id',
            'printSheetColumns'
        ) );
    }

    public function printSheetPrint( Request $request )
    {
        $this->validate( $request, [
            'branch_id' => 'required|numeric|exists:branches,id',
            'current_class_id' => 'required|numeric|exists:classes,id',
            'section_id' => 'required|numeric|exists:sections,id',
            'print_sheet_column_ids' => 'required',
            'print_sheet_column_ids.*' => 'required|exists:print_sheet_columns,id'
        ], [], [
            'branch_id' => 'Branch',
            'current_class_id' => 'Class',
            'section_id' => 'Section'
        ] );

        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $section_id = $request->section_id;
        $print_sheet_column_ids = $request->print_sheet_column_ids;

        $branch = Branch::find( $branch_id );
        $current_class = SchoolClass::find( $current_class_id );
        $section = Section::find( $section_id );
        $print_sheet_columns = PrintSheetColumn::whereIn( 'id', $print_sheet_column_ids )->get();

        $title = "Print sheet ({$branch->name}, {$current_class->name}, {$section->name})";
        $showPrintButtons = true;
        $printDate = Carbon::now();

        $students = Student::where( [
            'branch_id' => $branch_id,
            'current_class_id' => $current_class_id,
            'section_id' => $section_id
        ] )->orderBy( 'pin', 'asc' )->get();

        return view( 'print_sheet.print_sheet_print', compact(
            'title',
            'branch',
            'current_class',
            'section',
            'students',
            'showPrintButtons',
            'printDate',
            'print_sheet_columns'
        ) );
    }
}
