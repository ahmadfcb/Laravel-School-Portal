<?php

namespace App\Http\Controllers;

use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LeaveCertificateController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:leave_certificate_print' );
    }

    public function index( Request $request )
    {
        $title = "Character Certificate";

        $student = Student::with( ['branch', 'currentClass', 'section', 'fatherRecord'] )->findOrFail( $request->student_id );

        return view( 'leave_certificate.index', compact(
            'title',
            'student'
        ) );
    }

    public function print( Request $request )
    {
        $this->validate( $request, [
            'student_id' => 'required|numeric|exists:students,id',
            'date_of_leaving_school' => 'required|date',
            'conduct' => 'nullable',
            'remarks' => 'nullable'
        ] );

        $student = Student::with( ['classOfAdmission', 'branch', 'currentClass', 'section', 'fatherRecord'] )->findOrFail( $request->student_id );
        $title = "Character Certificate";
        $showPrintButtons = true;

        $date_of_leaving_school = Carbon::parse( $request->date_of_leaving_school );
        $conduct = $request->conduct;
        $remarks = $request->remarks;
        $current_date = Carbon::now();

        return view( 'leave_certificate.print', compact(
            'title',
            'student',
            'date_of_leaving_school',
            'conduct',
            'remarks',
            'showPrintButtons',
            'current_date'
        ) );
    }
}
