<?php

namespace App\Http\Controllers\Api;

use App\FatherRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FatherController extends Controller
{
    public function getDetails( Request $request )
    {
        $this->validate( $request, [
            'cnic' => 'required|exists:father_records,cnic'
        ],[
            'cnic.exists' => "CNIC Not Found"
        ] );

        return FatherRecord::whereCnic( $request->cnic )->first();
    }
}
