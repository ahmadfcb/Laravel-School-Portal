<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Option;
use App\PerformanceScale;
use App\PerformanceType;
use App\SchoolClass;
use App\Section;
use App\Student;
use App\StudentPerformance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentPerformanceController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware( 'CheckPrivilege:student_performance_mark' )->only( ['index', 'mark'] );
        $this->middleware( 'CheckPrivilege:student_performance_report' )->only( ['report'] );
    }

    public function index( Request $request )
    {
        $title = "Student Performance";
        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();
        $performance_types = PerformanceType::get();
        $performance_scales = PerformanceScale::get();

        $user = \Auth::user();
        $student_performance_edit_privilege = $user->userHasPrivilege( 'student_performance_edit' );

        $branch_id = $request->branch_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $date = $request->date;
        $date = ( empty( $date ) ? Carbon::now()->format( 'd-m-Y' ) : $date );
        $default_performance_scale_id = Option::getOptionValue('default_performance_scale_id');

        $students = [];
        $performanceExists = false;
        if ( !empty( $branch_id ) || !empty( $class_id ) || !empty( $section_id ) ) {
            $students = Student::with( ['fatherRecord', 'performances.performanceScale', 'performances.performanceType'] )
                ->getFiltered( $branch_id, $class_id, $section_id )
                ->orderBy( 'pin', 'asc' )
                ->get();

            // checking whether there exists any performance row for the students
            $performanceExists = StudentPerformance::whereIn( 'student_id', $students->pluck( 'id' ) )->where( 'performance_date', Carbon::parse( $date ) )->count();
            $performanceExists = ( $performanceExists > 0 ? true : false );
        }

        return view( 'student_performance.index', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'class_id',
            'section_id',
            'students',
            'performance_scales',
            'performance_types',
            'date',
            'performanceExists',
            'student_performance_edit_privilege',
            'default_performance_scale_id'
        ) );
    }

    public function studentPerformanceValidator( array $data )
    {
        $rules = [
            'date' => 'required|date',
            'students' => 'required',
            'students.*.student_id' => 'required|numeric|exists:students,id',
            'students.*.performance' => 'required',
            'students.*.performance.*.performance_type_id' => 'required|numeric|exists:performance_types,id',
            'students.*.performance.*.performance_scale_id' => 'required|numeric|exists:performance_scales,id'
        ];

        return \Validator::make( $data, $rules );
    }

    public function mark( Request $request )
    {
        $this->studentPerformanceValidator( $request->all() )->validate();

        $students = $request->students;
        $date = $request->date;

        // if provided date is greater than the current date
        if ( Carbon::parse( $date ) > Carbon::now()->startOfDay() ) {
            // redirect back
            return back()->with( 'msg', "Kindly select some valid date form the available calender." );
        }

        try {
            \DB::transaction( function () use ( $students, $date ) {
                foreach ( $students as $student ) {
                    foreach ( $student['performance'] as $performance ) {
                        $student_performance = StudentPerformance::firstOrNew( [
                            'student_id' => $student['student_id'],
                            'performance_date' => Carbon::parse( $date ),
                            'performance_type_id' => $performance['performance_type_id']
                        ] );
                        $student_performance->performance_scale_id = $performance['performance_scale_id'];
                        $student_performance->save();
                    }
                }
            } );

            return back()->with( 'msg', 'Performances has been saved.' );
        } catch ( \Exception $exception ) {
            $log_msg = "Student's performance wasn't marked!";
            $log_msg .= "\nError message: {$exception->getMessage()}";
            $log_msg .= "\nLogged in User:";
            $log_msg .= "\n\tUser id = " . auth()->user()->id;
            $log_msg .= "\n\tUser email = " . auth()->user()->email;
            \Log::warning( $log_msg );

            return back()->with( 'err', "Something went wrong. Please try again." );
        }
    }

    public function report( Request $request )
    {
        $title = "Student Performance Report";
        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();
        $performance_types = PerformanceType::get();

        $branch_id = $request->branch_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;

        $date_from = $request->date_from;
        $date_from = ( !empty( $date_from ) ? Carbon::parse( $date_from ) : Carbon::now() );

        $date_to = $request->date_to;
        $date_to = ( !empty( $date_to ) ? Carbon::parse( $date_to ) : Carbon::now() );

        $students = Student::with( ['fatherRecord', 'performances'] )->getFiltered( $branch_id, $class_id, $section_id )->orderBy( 'pin', 'asc' )->get();

        for ( $i = 0; $i < $students->count(); $i++ ) {
            $students[$i]->cus_performances = collect();

            foreach ( $performance_types as $performance_type ) {
                $cus_std_performance = StudentPerformance::with( ['performanceScale'] )->where( [
                    ['student_id', '=', $students[$i]->id],
                    ['performance_date', '>=', $date_from],
                    ['performance_date', '<=', $date_to],
                    ['performance_type_id', '=', $performance_type->id]
                ] )->get()->pluck( 'performanceScale' )->avg( 'scale_weight' );

                $cus_performance = collect( [
                    'performance_type_name' => $performance_type->name,
                    'performance_scale_weight_avg' => $cus_std_performance
                ] );

                $students[$i]->cus_performances->push( $cus_performance );
            }
        }

        return view( 'student_performance.report', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'class_id',
            'section_id',
            'date_from',
            'date_to',
            'students'
        ) );
    }

    public function studentReport( Request $request, Student $student )
    {
        $this->validate( $request, [
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ] );

        $student->load( ['fatherRecord', 'branch', 'currentClass', 'section'] );

        $title = "{$student->name}'s Performance Report";

        $date_from = $request->date_from;
        $date_from = ( !empty( $date_from ) ? Carbon::parse( $date_from ) : Carbon::now()->subMonth( 1 ) );

        $date_to = $request->date_to;
        $date_to = ( !empty( $date_to ) ? Carbon::parse( $date_to ) : Carbon::now() );

        $performance_type_ids = $request->performance_type_ids;

        $performance_types = PerformanceType::get();

        $student_performances = StudentPerformance::with( ['performanceScale', 'performanceType'] )->where( [
            ['student_id', '=', $student->id],
            ['performance_date', '>=', $date_from],
            ['performance_date', '<=', $date_to]
        ] );
        if ( !empty( $performance_type_ids ) ) {
            $student_performances->whereIn( 'performance_type_id', $performance_type_ids );
        }
        $student_performances = $student_performances->get();
        $student_performances_processed = [];

        $student_performances_dates = array_values( $student_performances->pluck( 'performance_date' )->unique()->toArray() );

        foreach ( $student_performances_dates as $key => $student_performances_date ) {
            $student_performances_processed[$key] = [
                'date' => $student_performances_date,
                'performances' => $student_performances->where( 'performance_date', $student_performances_date )
            ];
        }

        return view( 'student_performance.student_report', compact(
            'title',
            'date_from',
            'date_to',
            'performance_type_ids',
            'student',
            'performance_types',
            'student_performances',
            'student_performances_processed'
        ) );
    }
}
