<?php

namespace App\Http\Controllers;

use App\Student;
use App\StudentFeeArrear;
use App\StudentFeeTransaction;
use App\StudentFeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentFeeAssignController extends Controller
{
    public function index( Request $request )
    {
        $this->validate( $request, [
            'student_ids' => 'required|string'
        ] );
        $student_ids = explode( ',', urldecode( $request->student_ids ) );

        $students = Student::with( ['branch', 'currentClass', 'section'] )->whereIn( 'id', $student_ids )->get();

        $title = "Student Fee Assign";

        $studentFeeTypes = StudentFeeType::where( 'editable', 1 )->get();

        // adding or keeping the previous link to the session flash
        if ( $request->session()->has( '2ndBack' ) ) {
            $request->session()->keep( '2ndBack' );
        } else {
            $request->session()->flash( '2ndBack', \URL::previous() );
        }

        return view( 'student_fee_assign.index', compact(
            'title',
            'students',
            'studentFeeTypes'
        ) );
    }

    public function process( Request $request )
    {
        $this->validate( $request, [
            'student_ids' => 'required',
            'student_ids.*' => 'required|exists:students,id',
            'studentFeeTypes' => 'required',
            'studentFeeTypes.*' => 'required|exists:student_fee_types,id'
        ] );

        $students = Student::whereIn( 'id', $request->student_ids )->get();
        $studentFeeTypes = StudentFeeType::where( 'editable', 1 )->whereIn( 'id', $request->studentFeeTypes )->get();

        try {
            DB::transaction( function () use ( $students, $studentFeeTypes ) {
                foreach ( $students as $student ) {
                    $transaction_records = [];

                    foreach ( $studentFeeTypes as $studentFeeType ) {
                        // getting fee arrear and adding amount of fee type to it
                        $studentFeeArrear = StudentFeeArrear::firstOrNew( [
                            'student_id' => $student->id,
                            'student_fee_type_id' => $studentFeeType->id
                        ], ['arrear' => 0] );
                        $studentFeeArrear->arrear += $studentFeeType->fee;
                        $studentFeeArrear->save();

                        // record fee types that'll be added to the transaction record for the student's transaction
                        $transaction_records[] = [
                            'student_fee_type_id' => $studentFeeType->id,
                            'credit' => $studentFeeType->fee,
                            'debit' => 0,
                            'balance' => $studentFeeArrear->arrear
                        ];
                    }

                    // making transaction and adding transaction records to it
                    $studentFeeTransaction = StudentFeeTransaction::create( [
                        'student_id' => $student->id,
                        'description' => "Assigned fee to the student"
                    ] );
                    $studentFeeTransaction->records()->createMany( $transaction_records );
                }
            } );

            // Get 2nd previous url or the previous url and redirect back to it
            if ( session()->has( '2ndBack' ) ) {
                $url = session( '2ndBack' );
            } else {
                $url = \URL::previous();
            }
            return redirect( $url )->with( 'msg', "Fee type(s) assigned to the selected student(s)." );
        } catch ( \Exception $e ) {
            // keeping 2nd back link if it exists
            if ( $request->session()->has( '2ndBack' ) ) {
                $request->session()->keep( '2ndBack' );
            }

            // logging error and returning
            Log::error( "Wasn't able to assign fee types to the students", ['error_msg' => $e->getMessage()] );
            return back()->with( 'err', "Could not assign the fee to the students!" );
        }
    }
}
