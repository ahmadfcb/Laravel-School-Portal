<?php

namespace App\Http\Controllers\Api;

use App\SchoolClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassController extends Controller
{
    public function getClasses( Request $request )
    {
        $classes = SchoolClass::withoutGlobalScope('orderByName')->orderBy('name');

        if($request->branch_id){
            $classes->where('branch_id', $request->branch_id);
        }

        return $classes->get();
    }
}
