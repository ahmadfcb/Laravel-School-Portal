<?php

namespace App\Http\Controllers;

use App\Branch;
use App\SchoolClass;
use App\Section;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClassController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:class_view' );
        $this->middleware( 'CheckPrivilege:class_add' )->only( 'store' );
        $this->middleware( 'CheckPrivilege:class_edit' )->only( 'update' );
        $this->middleware( 'CheckPrivilege:class_delete' )->only( 'remove' );

        $this->middleware( 'CheckPrivilege:update_assigned_student_class_fee' )->only( 'updateAssignedClassFee' );
    }

    public function validator( array $data )
    {
        return Validator::make( $data, [
            'name' => 'required|string|max:191',
            'fee' => 'required|numeric|min:0'
        ] );
    }

    public function index( SchoolClass $classEdit )
    {
        $title = "Classes";

        $classes = SchoolClass::get();
        $branches = Branch::get();
        $sections = Section::get();

        return view( 'class.index', compact(
            'title',
            'classes',
            'classEdit',
            'branches',
            'sections'
        ) );
    }

    public function store( Request $request )
    {
        $this->validator( $request->all() )->validate();

        $schoolClass = new SchoolClass();
        $schoolClass->name = $request->name;
        $schoolClass->fee = $request->fee;
        $schoolClass->save();

        return back()->with( 'msg', "Class added successfully!" );
    }

    public function update( Request $request )
    {
        $this->validator( $request->all() )->validate();

        $class = SchoolClass::findOrFail( $request->id );
        $class->name = $request->name;
        $class->fee = $request->fee;
        $class->save();

        return redirect()->route( 'dashboard.class' )->with( 'msg', "Class has been updated." );
    }

    public function remove( SchoolClass $class )
    {
        $class->delete();
        return back()->with( 'msg', "Class has been deleted." );
    }

    public function updateAssignedClassFee( Request $request )
    {
        $this->validate( $request, [
            'student_ids' => 'required|string'
        ] );
        $student_ids = explode( ',', urldecode( $request->student_ids ) );

        $students = Student::with( ['currentClass'] )
            ->select( 'id', 'current_class_id', 'assigned_class_fee' )->whereIn( 'id', $student_ids )->get();

        try {
            \DB::transaction( function () use ( $students ) {
                // iterate over every student
                foreach ( $students as $student ) {
                    // if class for student exists
                    if ( !empty( $student->currentClass ) ) {
                        $student->assigned_class_fee = $student->currentClass->fee ?? 0;
                        $student->save();
                    }
                }
            } );

            return back()->with( 'msg', "Assigned fee of the students has been updated respective to their classes." );
        } catch ( Exception $e ) {
            Log::error( "Assigned fee update failed", ['url' => url()->current(), 'students' => $students] );
            return back()->with( 'err', "Something went wrong! Wasn't able to update class fee for the selected students. Kindly try again." );
        }
    }
}
