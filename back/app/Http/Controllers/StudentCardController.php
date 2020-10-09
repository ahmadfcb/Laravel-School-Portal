<?php

namespace App\Http\Controllers;

use App\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentCardController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function print( Request $request )
    {
        $this->validate( $request, [
            'student_ids' => 'required|string'
        ] );

        $title = "Student Cards";
        $showPrintButtons = true;
        $print_date = Carbon::now()->format( 'd-M-Y' );

        $student_ids = explode( ',', urldecode( $request->student_ids ) );

        $students = Student::with( [
            'branch',
            'currentClass',
            'section',
            'fatherRecord'
        ] )->whereIn( 'id', $student_ids )->get();

        return view( 'student_card.print', compact(
            'title',
            'students',
            'print_date',
            'showPrintButtons'
        ) );
    }
}
