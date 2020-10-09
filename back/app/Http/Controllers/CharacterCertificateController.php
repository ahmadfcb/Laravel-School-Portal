<?php

namespace App\Http\Controllers;

use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CharacterCertificateController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:character_certificate_print' );
    }

    public function index( Request $request )
    {
        $title = "Character Certificate";

        $student = Student::with( ['branch', 'currentClass', 'section', 'fatherRecord'] )->findOrFail( $request->student_id );

        return view( 'character_certificate.index', compact(
            'title',
            'student'
        ) );
    }

    public function print( Request $request )
    {
        $this->validate($request, [
            'student_id' => 'required|numeric|exists:students,id',
            'conduct' => 'required|string',
            'remarks' => 'nullable|string'
        ]);

        $student = Student::with( ['currentClass', 'fatherRecord'] )->findOrFail( $request->student_id );
        $title = "Character Certificate";
        $showPrintButtons = true;

        $conduct = $request->conduct;
        $remarks = $request->remarks;
        $date = Carbon::now();

        return view( 'character_certificate.print', compact(
            'title',
            'student',
            'conduct',
            'remarks',
            'showPrintButtons',
            'date'
        ) );
    }
}
