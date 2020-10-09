<?php

namespace App\Http\Controllers;

use App\Student;
use App\Withdrawal;
use Illuminate\Http\Request;

class StudentWithdrawController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:student_withdraw' );
    }

    public function index( Student $student )
    {
        if ( $student->withdrawn != 0 ) {
            return back()->with( 'err', "Student has already been withdrawn from the school." );
        }

        $student->load( ['branch', 'currentClass', 'section', 'fatherRecord'] );

        $title = "Student Withdraw";

        return view( 'student_withdraw.index', compact(
            'title',
            'student'
        ) );
    }

    public function withdraw( Request $request, Student $student )
    {
        $this->validate( $request, [
            'comment' => 'nullable|string|max:65535',
            'certificate_issued' => 'required|in:0,1',
            'redirect_back' => 'required|string'
        ] );

        $comment = $request->comment;
        $certificate_issued = $request->certificate_issued;
        $redirect_back = $request->redirect_back;
        $redirect_back = ( $redirect_back ?: route( 'dashboard.student' ) );

        try {
            \DB::transaction( function () use ( $comment, $certificate_issued, $student ) {
                $student->withdrawn = 1;
                $student->save();

                Withdrawal::create( [
                    'student_id' => $student->id,
                    'comment' => $comment,
                    'certificate_issued' => $certificate_issued
                ] );
            } );

            return redirect( $redirect_back )->with( 'msg', "Student has been withdrawn" );
        } catch ( \Exception $e ) {
            return back()->with( 'err', "Something went wrong! Please try again." );
        }
    }
}
