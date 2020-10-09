<?php

namespace App\Http\Controllers;

use App\StudentAttendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware( 'auth' );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Dashboard";
        // $availableButtons = $this->availablebuttons();

        return view( 'home.index', compact(
            'title'
            /*,
            'availableButtons' */
        ) );
    }

    public function availablebuttons()
    {
        $buttons = [];
        $user = auth()->user();

        if ( $user->userHasPrivilege( ['student_admission'] ) ) {
            $buttons[] = [
                'text' => 'Admission',
                'link' => route( 'dashboard.student.admission' )
            ];
        }

        if ( $user->userHasPrivilege( ['student_view'] ) ) {
            $buttons[] = [
                'text' => 'Students',
                'link' => route( 'dashboard.student' )
            ];
        }

        if ( $user->userHasPrivilege( ['student_attendance_mark'] ) ) {
            $buttons[] = [
                'text' => 'Student Attendance',
                'link' => route( 'dashboard.student_attendance' )
            ];
        }

        if ( $user->userHasPrivilege( ['student_performance_mark'] ) ) {
            $buttons[] = [
                'text' => 'Student Performance',
                'link' => route( 'dashboard.student_performance' )
            ];
        }

        if ( $user->userHasPrivilege( ['receive_fee'] ) ) {
            $buttons[] = [
                'text' => 'Receive Fee',
                'link' => route( 'dashboard.student_fee.receive_fee.mass' )
            ];
        }

        return $buttons;
    }
}
