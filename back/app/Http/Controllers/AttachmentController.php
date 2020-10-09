<?php

namespace App\Http\Controllers;

use App\StudentAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
    }

    public function delete( StudentAttachment $studentAttachment )
    {
        Storage::delete( $studentAttachment->path );

        $studentAttachment->delete();

        return back()->with( 'msg', "Selected attachment has been deleted!" );
    }
}
