<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:section_view' );
        $this->middleware( 'CheckPrivilege:section_add' )->only( 'store' );
        $this->middleware( 'CheckPrivilege:section_edit' )->only( 'update' );
        $this->middleware( 'CheckPrivilege:section_delete' )->only( 'remove' );
    }

    public function validator( array $data )
    {
        return Validator::make($data, [
            'name' => 'required|string|max:191'
        ]);
    }

    public function index( Section $sectionEdit )
    {
        $title = "Sections";

        $sections = Section::get();

        return view( 'section.index', compact(
            'title',
            'sections',
            'sectionEdit'
        ) );
    }

    public function store( Request $request )
    {
        $this->validator( $request->all() )->validate();

        Section::create( [
            'name' => $request->name
        ] );

        return back()->with( 'msg', "Section added successfully!" );
    }

    public function update( Request $request )
    {
        $this->validator( $request->all() )->validate();

        $section = Section::findOrFail( $request->id );
        $section->name = $request->name;
        $section->save();

        return redirect()->route( 'dashboard.section' )->with( 'msg', "section has been updated." );
    }

    public function remove(Section $section)
    {
        $section->delete();
        return Redirect::route('dashboard.section')->with('msg', "Section Deleted.");
    }
}
