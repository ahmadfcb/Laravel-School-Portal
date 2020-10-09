<?php

namespace App\Http\Controllers;

use App\Branch;
use App\SchoolClass;
use App\Section;
use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceSheetController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('CheckPrivilege:student_attendance_sheet');
    }

    public function show( Request $request )
    {
        $title = "Attendance Sheet";

        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();

        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $section_id = $request->section_id;

        return view( 'attendance_sheet.show', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'current_class_id',
            'section_id'
        ) );
    }

    public function print( Request $request )
    {
        $this->validate( $request, [
            'branch_id' => 'required|numeric|exists:branches,id',
            'current_class_id' => 'required|numeric|exists:classes,id',
            'section_id' => 'required|numeric|exists:sections,id'
        ], [], [
            'branch_id' => 'Branch',
            'current_class_id' => 'Class',
            'section_id' => 'Section'
        ] );

        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $section_id = $request->section_id;

        $branch = Branch::find( $branch_id );
        $current_class = SchoolClass::find( $current_class_id );
        $section = Section::find( $section_id );

        $title = "Attendance sheet ({$branch->name}, {$current_class->name}, {$section->name})";
        $showPrintButtons = true;
        $printDate = Carbon::now();

        $students = Student::where( [
            'branch_id' => $branch_id,
            'current_class_id' => $current_class_id,
            'section_id' => $section_id
        ] )->orderBy('pin', 'asc')->get();

        return view( 'attendance_sheet.print', compact(
            'title',
            'branch',
            'current_class',
            'section',
            'students',
            'showPrintButtons',
            'printDate'
        ) );
    }
}
