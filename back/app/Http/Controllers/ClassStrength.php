<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Section;
use App\SchoolClass;
use App\Branch;

class ClassStrength extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $simpeTitle = "Students";
        $branches = Branch::get();
        $classes = SchoolClass::get();
        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $sections = Section::get();
        $section_id = $request->section_id;
        $students = Student::get();
       
        

        $students_count = [
            'total' => $students->count(),
            'male' => $students->where( 'gender', 'male' )->count(),
            'female' => $students->where( 'gender', 'female' )->count(),
            'kg'=>$students->where('branch_id','9')->count(),
            'junior'=>$students->where('branch_id','10')->count(),
            'boys'=>$students->where('branch_id','11')->count(),
            'girls'=>$students->where('branch_id','12')->count()
        ];

         $title = "{$simpeTitle} (Total: {$students_count['total']}, Male: {$students_count['male']}, Female: {$students_count['female']})";
        return view('Class_Strength.index',compact('branches','classes','sections','students','branch_id','current_class_id','section_id','students_count','title'));

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
    public function store(Request $request)
    {
        //
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
