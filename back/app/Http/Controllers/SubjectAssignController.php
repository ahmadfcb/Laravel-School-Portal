<?php

namespace App\Http\Controllers;

use App\Branch;
use App\BranchClassSection;
use App\SchoolClass;
use App\Section;
use App\Subjects;
use Illuminate\Http\Request;

class SubjectAssignController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:subject_assign_view' );
    }

    public function index( BranchClassSection $editItem )
    {
        $editItem->load( ['subjects'] );

        $title = "Subject Assignment";

        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();
        $subjects = Subjects::get();

        $assignedSubjects = BranchClassSection::has( 'branchClassSectionSubjects' )
            ->with( ['branch', 'schoolClass', 'section', 'branchClassSectionSubjects.subject'] )
            ->get();

        return view( 'subject_assign.index', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'subjects',
            'assignedSubjects',
            'editItem'
        ) );
    }

    public function assignSubjectValidator( array $data )
    {
        $rules = [
            'branch_id' => 'required|numeric|exists:branches,id',
            'class_id' => 'required|numeric|exists:classes,id',
            'section_id' => 'required|numeric|exists:sections,id',
            'subject_ids.*' => 'required|numeric|exists:subjects,id'
        ];


        if ( \request()->isMethod( 'put' ) ) {
            $rules['branch_class_section_id'] = 'required|numeric|exists:branch_class_section,id';
        }

        return \Validator::make( $data, $rules );
    }

    public function store( Request $request )
    {
        $this->assignSubjectValidator( $request->all() )->validate();

        $branch_id = $request->branch_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $subject_ids = $request->subject_ids;

        $branchClassSection = BranchClassSection::firstOrCreate( [
            'branch_id' => $branch_id,
            'class_id' => $class_id,
            'section_id' => $section_id
        ] );

        // if subjects related to the branch class section already exists
        if ( $branchClassSection->subjects()->exists() ) {
            return back()->with( 'err', "Subjects has already been assigned to provided branch, class and section. You should click on the edit button next to the corresponding entry within <b>Assigned Subjects</b>." );
        } else {
            $branchClassSection->subjects()->sync( $subject_ids );

            return back()->with( 'msg', "Subjects has been assigned successfully!" );
        }
    }

    public function update( Request $request )
    {
        $this->assignSubjectValidator( $request->all() )->validate();

        $branch_id = $request->branch_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $subject_ids = $request->subject_ids;

        $branchClassSection = BranchClassSection::firstOrCreate( [
            'branch_id' => $branch_id,
            'class_id' => $class_id,
            'section_id' => $section_id
        ] );

        $branchClassSection->subjects()->sync( $subject_ids );

        return redirect()->route( 'dashboard.subject_assignment' )->with( 'msg', "Subjects has been updated for provided branch, class and section." );
    }
}
