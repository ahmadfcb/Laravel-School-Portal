<?php

namespace App\Http\Controllers;

use App\Option;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentFeeGeneration extends Controller
{
    public function __construct()
    {
        $this->middleware( 'CheckPrivilege:generate_students_fee' );
    }

    public function manualGeneration()
    {
        $title = "Students' Fee Generation";

        $students_last_fee_generation_date_time = Option::getOptionValue( 'students_last_fee_generation_date_time' );
        $students_last_fee_generation_date_time = ( empty( $students_last_fee_generation_date_time ) ? null : Carbon::parse( $students_last_fee_generation_date_time ) );

        $allow_automatic_fee_generate = Option::getOptionValue('allow_automatic_fee_generate');

        return view( 'student_fee_generation.manual_generation', compact(
            'title',
            'students_last_fee_generation_date_time',
            'allow_automatic_fee_generate'
        ) );
    }

    public function manualGenerationProcess()
    {
        \Artisan::call( 'student:generate-monthly-fee' );

        return back()->with( 'msg', "Fee Generation Completed" );
    }
}
