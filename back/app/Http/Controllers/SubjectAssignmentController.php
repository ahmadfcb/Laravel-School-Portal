<?php

namespace App\Http\Controllers;

use App\ClassSection;
use App\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectAssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:subject_assignment_view' );
        $this->middleware('CheckPrivilege:subject_assignment_edit')->only('update');
    }

    public function validator( array $data )
    {
        return Validator::make( $data, [
            'id' => 'numeric|exists:class_section,id',
            'subjects.*' => 'numeric|exists:subjects,id'
        ] );
    }

    public function index( ClassSection $classSectionEdit )
    {
        $classSectionEdit->load( ['schoolClass.branch', 'section', 'subjects'] );

        $title = "Subject Assignment";

        $classSections = ClassSection::with( 'subjects', 'schoolClass.branch', 'section' )->get();
        $subjects = Subjects::get();

        return view( 'subject_assignment.index', compact(
            'title',
            'classSections',
            'classSectionEdit',
            'subjects'
        ) );
    }

    public function update( Request $request )
    {
        $this->validator( $request->all() )->validate();

        $classSection = ClassSection::findOrFail( $request->id );
        $classSection->subjects()->sync( $request->subjects );

        return redirect()->route('dashboard.subjectAssignment')->with('msg', "Subjects updated.");
    }
}
