<?php

namespace App\Http\Controllers;

use App\StudentFeeType;
use Illuminate\Http\Request;

class StudentFeeTypeController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:student_fee_type_view' );
        $this->middleware( 'CheckPrivilege:student_fee_type_delete' )->only( 'delete' );
    }

    public function index( StudentFeeType $studentFeeTypeEdit )
    {
        // if current request is for edit page and current fee type is NOT editable
        if ( $studentFeeTypeEdit->id !== null && $studentFeeTypeEdit->editable == 0 ) {
            return back()->with( 'err', "Requested student fee type is not editable" );
        }

        $title = "Student Fee Types";

        $studentFeeTypes = StudentFeeType::orderBy( 'name' )->get();

        return view( 'student_fee_type.index', compact(
            'title',
            'studentFeeTypes',
            'studentFeeTypeEdit'
        ) );
    }

    public function add( Request $request, StudentFeeType $studentFeeTypeEdit )
    {
        $this->validate( $request, [
            'name' => 'required|string',
            'fee' => 'required|numeric'
        ] );

        $name = $request->name;
        $fee = $request->fee;

        // if Student Fee type edit is given. Update record
        if ( $studentFeeTypeEdit->id !== null ) {

            // if fee type is not editable
            if ( $studentFeeTypeEdit->editable == 0 ) {
                return back()->with( 'err', "Requested student fee type is not editable" );
            }

            if ( !\Auth::user()->userHasPrivilege( 'student_fee_type_edit' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            $studentFeeTypeEdit->name = $name;
            $studentFeeTypeEdit->fee = $fee;
            $studentFeeTypeEdit->save();
            return redirect()->route( 'dashboard.student_fee.type' )->with( 'msg', "Student Fee Type Updated" );
        } else { // create new

            if ( !\Auth::user()->userHasPrivilege( 'student_fee_type_add' ) ) {
                abort( 401, "You are not authorized to view that page." );
            }

            StudentFeeType::create( ['name' => $name, 'fee' => $fee, 'editable' => 1] );
            return back()->with( 'msg', "Student Fee Type has been created." );
        }
    }

    public function delete( StudentFeeType $studentFeeType )
    {
        // if provided fee type is not edit able
        if ( $studentFeeType->editable == 0 ) {
            return back()->with( 'err', "Requested student fee type cannot be deleted!" );
        }

        $studentFeeType->delete();
        return back()->with( 'msg', "Student fee type (<b>{$studentFeeType->name}</b>) has been deleted successfully." );
    }
}
