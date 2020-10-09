<?php

namespace App\Http\Controllers\Api;

use App\SchoolClass;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function getSections( Request $request )
    {
        $class_id = $request->class_id;

        if ( $class_id ) {
            $sections = SchoolClass::find( $class_id )->sections()->get();
        } else {
            $sections = Section::orderBy( 'name' )->get();
        }

        return $sections;
    }
}
