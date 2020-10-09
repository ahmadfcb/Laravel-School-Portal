<?php

namespace App\Http\Controllers;

use App\Branch;
use App\SchoolClass;
use App\Section;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoteDemoteStudentsController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:promote_demote_student' );
    }

    public function index( Request $request )
    {
        $this->validate( $request, [
            'student_ids' => 'required|string'
        ] );
        $student_ids = explode( ',', urldecode( $request->student_ids ) );

        $students = Student::with( ['branch', 'currentClass', 'section', 'fatherRecord'] )->whereIn( 'id', $student_ids )->get();

        $title = "Promote Demote Students";

        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();

        // if back link exists, keep it, store it otherwise
        if ( \Session::has( 'redirect_back_url' ) ) {
            \Session::keep( 'redirect_back_url' );
        } else {
            \Session::flash( 'redirect_back_url', \URL::previous() );
        }

        return view( 'promote_demote_students.index', compact(
            'title',
            'students',
            'branches',
            'classes',
            'sections'
        ) );
    }

    public function process( Request $request )
    {
        $this->validate( $request, [
            'branch' => 'required|exists:branches,id',
            'class' => 'required|exists:classes,id',
            'section' => 'required|exists:sections,id',
            'students' => 'required',
            'students.*' => 'required|integer|exists:students,id'
        ] );

        $branch_id = $request->branch;
        $class_id = $request->class;
        $section_id = $request->section;
        $student_ids = $request->students;

        Student::whereIn( 'id', $student_ids )->update( [
            'branch_id' => $branch_id,
            'current_class_id' => $class_id,
            'section_id' => $section_id
        ] );

        if ( \Session::has( 'redirect_back_url' ) ) {
            $url = \Session::get( 'redirect_back_url' );
        } else {
            $url = \URL::route( 'dashboard.student' );
        }

        return redirect( $url )->with( 'msg', "Selected students have been promoted/demoted successfully!" );
    }
}
