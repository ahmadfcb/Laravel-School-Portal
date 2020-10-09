<?php

namespace App\Http\Controllers;

use App\StudentAttendanceType;
use Illuminate\Http\Request;

class AttendanceTypeController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:attendance_type_view' );
        $this->middleware( 'CheckPrivilege:subject_assign_add' )->only( 'store' );
        $this->middleware( 'CheckPrivilege:attendance_type_update' )->only( 'update' );
        $this->middleware( 'CheckPrivilege:attendance_type_delete' )->only( 'remove' );
    }

    public function attendanceTypeValidator( array $data )
    {
        $rules = [
            'name' => 'required|string|max:191'
        ];

        if ( \request()->isMethod( 'put' ) ) {
            $rules['id'] = "required|numeric|exists:student_attendance_types,id";
        }

        return \Validator::make( $data, $rules );
    }

    public function index( StudentAttendanceType $editItem )
    {
        $title = "Attendance Types";
        $student_attendance_types = StudentAttendanceType::get();

        return view( 'attendance_type.index', compact(
            'title',
            'student_attendance_types',
            'editItem'
        ) );
    }

    public function store( Request $request )
    {
        $this->attendanceTypeValidator( $request->all() )->validate();

        StudentAttendanceType::create( [
            'name' => $request->name
        ] );

        return back()->with( 'msg', "Student Attendance type has been created!" );
    }

    public function update( Request $request )
    {
        $this->attendanceTypeValidator( $request->all() )->validate();

        $student_attendance_type = StudentAttendanceType::findOrFail( $request->id );
        $student_attendance_type->name = $request->name;
        $student_attendance_type->save();

        return redirect()->route( 'dashboard.attendance_type' )->with( 'msg', "Name of attendance type updated to '{$student_attendance_type->name}'." );
    }

    public function remove( StudentAttendanceType $studentAttendanceType )
    {
        $studentAttendanceType->delete();

        return back()->with( 'msg', "Attendance Type '{$studentAttendanceType->name}' has been deleted" );
    }
}
