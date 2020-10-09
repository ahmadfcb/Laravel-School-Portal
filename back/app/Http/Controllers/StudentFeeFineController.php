<?php

namespace App\Http\Controllers;

use App\Branch;
use App\SchoolClass;
use App\Section;
use App\Student;
use App\StudentFeeArrear;
use App\StudentFeeType;
use Illuminate\Http\Request;

class StudentFeeFineController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:edit_fee_fine_arrears' )->only( ['editStudentFeeFinePage', 'saveFeeFineArrears'] );
        $this->middleware( 'CheckPrivilege:edit_fee_fine_arrears_multiple' )->only( ['editMultiple', 'editMultipleUpdate'] );
    }

    public function editStudentFeeFinePage( Student $student )
    {
        $student->load( ['branch', 'currentClass', 'section', 'fatherRecord'] );

        $title = "Edit Fee and Fine Arrears";

        $nextStudent = ( empty( $student->pin ) ? null : Student::where( 'pin', '>', $student->pin )->orderBy( 'pin' )->first() );
        $previousStudent = ( empty( $student->pin ) ? null : Student::where( 'pin', '<', $student->pin )->orderBy( 'pin', 'desc' )->first() );

        return view( 'student_fee_fine.edit_student_fee_fine_page', compact(
            'title',
            'student',
            'nextStudent',
            'previousStudent'
        ) );
    }

    public function saveFeeFineArrears( Request $request, Student $student )
    {
        $total_fee_arrears = $request->total_fee_arrears;
        $total_fine_arrears = $request->total_fine_arrears;

        $student->total_fee_arrears = $total_fee_arrears;
        $student->total_fine_arrears = $total_fine_arrears;
        $student->save();

        return back()->with( 'msg', "Fee and Fine arrears has been updated for {$student->name}!" );
    }

    public function editMultiple( Request $request )
    {
        $title = "Edit Fee related arrears";

        $user = \Auth::user();

        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();

        $branch_id = $request->branch_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;

        $studentFeeTypes = StudentFeeType::orderBy( 'editable' )->orderBy( 'name' )->get();

        $students = Student::with( ['fatherRecord', 'branch', 'currentClass', 'section', 'category'] )
            ->getFiltered( $branch_id, $class_id, $section_id )
            ->orderBy( 'pin' )
            ->get();

        // appending student fee arrears to all the students separately
        for ( $i = 0; $i < count( $students ); $i++ ) {

            $student_fee_arrears = [];
            for ( $j = 0; $j < count( $studentFeeTypes ); $j++ ) {
                $student_fee_arrear = [
                    'feeTypeId' => $studentFeeTypes[$j]->id,
                    'feeType' => $studentFeeTypes[$j]->name,
                    'value' => StudentFeeArrear::where( 'student_id', $students[$i]->id )->where( 'student_fee_type_id', $studentFeeTypes[$j]->id )->first()->arrear ?? 0
                ];

                $student_fee_arrears[] = $student_fee_arrear;
            }

            $students[$i]->student_fee_arrears = $student_fee_arrears;

            // calculate and append student's payable monthly fee to each student
            $payable_monthly_fee = ( $students[$i]->currentClass->fee ?? 0 ) - ( $students[$i]->category->fee_discount ?? 0 ) - ( $students[$i]->extra_discount ?? 0 );
            $students[$i]->payable_monthly_fee = ( $payable_monthly_fee < 0 ? 0 : $payable_monthly_fee );
            // append without extra discount too
            $monthly_fee_without_extra_discount = ( $students[$i]->currentClass->fee ?? 0 ) - ( $students[$i]->category->fee_discount ?? 0 );
            $students[$i]->monthly_fee_without_extra_discount = ( $monthly_fee_without_extra_discount < 0 ? 0 : $monthly_fee_without_extra_discount );
        }

        $permissions = [
            'can_edit_extra_discount' => $user->userHasPrivilege( 'can_edit_extra_discount' )
        ];

        $totals = [];
        $totals['total_students'] = $students->count();
        $totals['total_male'] = $students->where('gender', 'male')->count();
        $totals['total_female'] = $students->where('gender', 'female')->count();

        return view( 'student_fee_fine.edit_multiple', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'class_id',
            'section_id',
            'students',
            'studentFeeTypes',
            'permissions',
            'totals'
        ) );
    }

    public function editMultipleUpdate( Request $request )
    {
        $this->validate( $request, [
            'students' => 'required',
            'students.*.student_id' => 'required|integer|exists:students,id',
            'students.*.extra_discount' => 'required',
            'students.*.fee_arrears' => 'required',
            'students.*.fee_arrears.*.fee_type_id' => 'required|integer|exists:student_fee_types,id',
            'students.*.fee_arrears.*.arrear' => 'required|numeric',
        ] );

        $students = $request->students;

        try {
            \DB::transaction( function () use ( $students ) {
                foreach ( $students as $student ) {
                    $student_id = $student['student_id'];
                    $fee_arrears = $student['fee_arrears'];
                    $extra_discount = $student['extra_discount'];

                    // updating student's extra discount
                    Student::where( 'id', $student_id )->update( ['extra_discount' => $extra_discount] );

                    // updating every fee arrear for the student if it exists otherwise new will be created
                    foreach ( $fee_arrears as $fee_arrear ) {
                        $fee_type_id = $fee_arrear['fee_type_id'];
                        $arrear = $fee_arrear['arrear'];

                        $studentFeeArrear = StudentFeeArrear::firstOrNew( ['student_id' => $student_id, 'student_fee_type_id' => $fee_type_id] );
                        $studentFeeArrear->arrear = $arrear;
                        $studentFeeArrear->save();
                    }
                }
            } );

            return back()->with( 'msg', "Fee arrears updated successfully" );
        } catch ( \Exception $e ) {
            \Log::error( "Fee arrears were not update for multiple students.", ['errorMessageGenerated' => $e->getMessage()] );
            return back()->with( 'err', 'Something went wrong! Please try again.' );
        }
    }
}
