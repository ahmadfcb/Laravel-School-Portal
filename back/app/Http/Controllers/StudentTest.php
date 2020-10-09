<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\student_test;
use App\Student_Tests;
use App\StudentMark;
use App\StudentSubject;
use App\Branch;
use App\Option;
use App\SchoolClass;
use App\Section;
use App\Student;
use App\testType;
use App\StudentAttendance;
use App\StudentAttendanceType;
use Carbon\Carbon;

class StudentTest extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user=Student_Tests::get();
        $branch=Branch::get();
        $student=Student::get();
        $section=Section::get();
        $class = SchoolClass::get();
        $type=testType::get();
        $test_id=$request->test_id;
        $section_id = $request->section_id;
        $class_id = $request->class_id;
        $branch_id = $request->branch_id;
        $marks=$request->result_test;
        $result_test=$request->result_test;
        if ($result_test== 'saved') {
        return redirect()->route('dashboard.reports');}

        return view('student_test.index',compact('user','branch','student','section','class','branch_id','class_id','section_id','type','test_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markMarks(Request $request)
    {
        $result_test=$request->result_test;
        if ($result_test== 'save') {
        return redirect()->route('dashboard.Reports');}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
