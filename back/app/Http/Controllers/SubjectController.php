<?php

namespace App\Http\Controllers;

use App\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:subject_view' );
        $this->middleware( 'CheckPrivilege:subject_add' )->only( 'store' );
        $this->middleware( 'CheckPrivilege:subject_edit' )->only( 'update' );
        $this->middleware( 'CheckPrivilege:subject_delete' )->only( 'remove' );
    }

    public function validator( array $data )
    {
        return Validator::make( $data, [
            'subject' => 'required|string|max:191'
        ] );
    }

    public function index( Subjects $subjectEdit )
    {
        $title = "Subjects";

        $subjects = Subjects::get();

        return view( 'subject.index', compact(
            'title',
            'subjects',
            'subjectEdit'
        ) );
    }

    public function store( Request $request )
    {
        $this->validator( $request->all() )->validate();

        Subjects::create( [
            'name' => $request->subject
        ] );

        return back()->with( 'msg', "Subject added successfully!" );
    }

    public function update( Request $request )
    {
        $this->validator( $request->all() )->validate();

        $subject = Subjects::findOrFail( $request->id );
        $subject->name = $request->subject;
        $subject->save();

        return redirect()->route( 'dashboard.subject' )->with( 'msg', "Subject has been updated." );
    }

    public function remove( Subjects $subject )
    {
        $subject->delete();
        return back()->with( 'msg', "Subject has been deleted." );
    }
}
