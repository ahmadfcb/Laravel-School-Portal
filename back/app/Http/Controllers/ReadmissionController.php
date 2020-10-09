<?php

namespace App\Http\Controllers;

use App\Readmission;
use App\Student;
use Illuminate\Http\Request;

class ReadmissionController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:student_readmission' );
    }

    public function index( $student )
    {
        $student = Student::withoutGlobalScope( 'notWithdrawn' )->findOrFail( $student );

        // student is not withdrawn
        if ( $student->withdrawn == 0 ) {
            return back()->with( 'err', "Student is not withdrawn!" );
        }

        $student->load( ['branch', 'currentClass', 'section', 'fatherRecord'] );

        $title = "Student Readmission";

        return view( 'readmission.index', compact(
            'title',
            'student'
        ) );
    }

    public function withdraw( Request $request, $student )
    {
        $student = Student::withoutGlobalScope( 'notWithdrawn' )->findOrFail( $student );

        $this->validate( $request, [
            'comment' => 'nullable|string|max:65535',
            'redirect_back' => 'required|string'
        ] );

        $comment = $request->comment;
        $redirect_back = $request->redirect_back;
        $redirect_back = ( $redirect_back ?: route( 'dashboard.student' ) );

        try {
            \DB::transaction( function () use ( $comment, $student ) {
                $student->withdrawn = 0;
                $student->save();

                Readmission::create( [
                    'student_id' => $student->id,
                    'comment' => $comment
                ] );
            } );

            return redirect( $redirect_back )->with( 'msg', "Student has been re-enrolled" );
        } catch ( \Exception $e ) {
            return back()->with( 'err', "Something went wrong! Please try again." );
        }
    }
}
