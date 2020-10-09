<?php

namespace App\Http\Controllers;

use App\Libraries\SmsLibrary;
use App\Libraries\UrlLibrary;
use App\SmsTemplate;
use App\Student;
use Illuminate\Http\Request;

class ManualSmsController extends Controller
{
    public function __construct()
    {
        $this->middleware( 'CheckPrivilege:send_manual_sms' );
    }

    public function index( Request $request )
    {
        $this->validate( $request, [
            'student_ids' => 'required|string'
        ] );
        $student_ids = explode( ',', urldecode( $request->student_ids ) );

        $students = Student::with( ['branch', 'currentClass', 'section', 'fatherRecord'] )->whereIn( 'id', $student_ids )->get();

        UrlLibrary::storeOrKeepBackUrl();

        $title = "Manual Messages";

        $smsTemplates = SmsTemplate::get();

        return view( 'manual_sms.index', compact(
            'title',
            'students',
            'smsTemplates'
        ) );
    }

    public function sendSMS( Request $request )
    {
        $this->validate( $request, [
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|integer|exists:students,id',
            'sms_content' => 'required|string'
        ] );

        $student_ids = $request->student_ids;
        $sms_content = $request->sms_content;

        $students = Student::with( ['fatherRecord', 'branch', 'currentClass', 'section'] )->whereIn( 'id', $student_ids )->get();

        $smsError = [];
        foreach ( $students as $student ) {
            $rendererdTemplate = SmsTemplate::renderTemplateContent( $sms_content, $student );
            $phoneNo = $student->getAvailablePhoneNumber();

            if ( $phoneNo !== null ) {
                $send_sms = SmsLibrary::send_sms( $phoneNo, $rendererdTemplate );

                if ( $send_sms['status'] === false ) {
                    $smsError[] = "Could not send SMS to student with PIN: {$student->pin}. Issue: {$send_sms['msg']}";
                }
            }
        }

        // setting sms error messages if they exist
        if ( !empty( $smsError ) ) {
            $request->session()->flash( 'err', $smsError );
        }

        return redirect( UrlLibrary::getBackUrl() )->with( 'msg', "SMS sending for selected students has been processed" );
    }
}
