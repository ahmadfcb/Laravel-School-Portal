<?php

namespace App\Http\Controllers;

use App\Option;
use App\PerformanceScale;
use App\PerformanceType;
use App\SmsTemplate;
use App\StudentAttendanceType;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:modify_options' );
    }

    public function index()
    {
        $title = "Options";
        $student_attendance_types = StudentAttendanceType::get();

        $smsTemplates = SmsTemplate::get();

        $default_student_attendance_type = Option::find( 'default_student_attendance_type' );
        $fee_submission_due_date = Option::find( 'fee_submission_due_date' );
        $fee_fine_after_due_date = Option::find( 'fee_fine_after_due_date' );
        $allow_automatic_fee_generate = Option::find( 'allow_automatic_fee_generate' );
        $sms_on_admission = Option::find( 'sms_on_admission' );
        $send_automatic_sms = Option::find( 'send_automatic_sms' );

        $performance_scales = PerformanceScale::get();
        $default_performance_scale_id = Option::find('default_performance_scale_id');

        return view( 'option.index', compact(
            'title',
            'student_attendance_types',
            'default_student_attendance_type',
            'fee_submission_due_date',
            'fee_fine_after_due_date',
            'allow_automatic_fee_generate',
            'sms_on_admission',
            'smsTemplates',
            'send_automatic_sms',
            'performance_scales',
            'default_performance_scale_id'
        ) );
    }

    public function save( Request $request )
    {
        $this->validate( $request, [
            'default_student_attendance_type' => 'required',
            'fee_submission_due_date' => 'required|integer|min:1|max:25',
            'fee_fine_after_due_date' => 'required|integer|min:0',
            'allow_automatic_fee_generate' => 'required|in:0,1',
            'default_performance_scale_id' => 'required|integer|exists:performance_scales,id',
            'send_automatic_sms' => 'nullable|in:0,1',
        ] );

        $default_student_attendance = Option::firstOrNew( ['name' => 'default_student_attendance_type'] );
        $default_student_attendance->value = $request->default_student_attendance_type;
        $default_student_attendance->save();

        Option::where( 'name', 'fee_submission_due_date' )->update( ['value' => $request->fee_submission_due_date] );
        Option::where( 'name', 'fee_fine_after_due_date' )->update( ['value' => $request->fee_fine_after_due_date] );
        Option::where( 'name', 'default_performance_scale_id' )->update( ['value' => $request->default_performance_scale_id] );
        Option::where( 'name', 'allow_automatic_fee_generate' )->update( ['value' => $request->allow_automatic_fee_generate] );

        $send_automatic_sms = ( $request->send_automatic_sms == 1 ? 1 : 0 );
        Option::where( 'name', 'send_automatic_sms' )->update( ['value' => $send_automatic_sms] );

        return back()->with( 'msg', 'Changes saved!' );
    }
}
