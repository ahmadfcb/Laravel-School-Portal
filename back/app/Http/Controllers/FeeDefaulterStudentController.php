<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Option;
use App\SchoolClass;
use App\Section;
use App\Student;
use Illuminate\Http\Request;
use DB;
use App\StudentAttendanceType;
use Carbon\Carbon;
use App\StudentAttendance;

class FeeDefaulterStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware( 'CheckPrivilege:view_defaulters_list' );
    }

    public function index( Request $request )
    {
        $this->validate( $request, [
            'branch_id' => 'nullable|integer',
            'current_class_id' => 'nullable|integer',
            'section_id' => 'nullable|integer',
            'greater_than_equal' => 'nullable|integer|min:0',
            'less_than_equal' => 'nullable|integer|min:0',
            'defaulter_report_type' => 'nullable|string|in:overall,current_month',
        ] );

        $title = "Fee defaulter students";

        $now = now();

        $branch_id = $request->branch_id;
        $current_class_id = $request->current_class_id;
        $section_id = $request->section_id;
        $greater_than_equal = $request->greater_than_equal;
        $less_than_equal = $request->less_than_equal;
        $defaulter_report_type = $request->defaulter_report_type;
        $defaulter_report_type = ( $defaulter_report_type == 'overall' ? 'overall' : 'current_month' );

        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();

        $students = Student::with( ['branch', 'currentClass', 'section', 'fatherRecord', 'feeArrears' => function ( $query ) {
            $query->where( 'arrear', '>', 0 );
        }, 'feeTransactions' => function ( $query ) use ( $now ) {
            $query->whereDate( 'created_at', 'like', $now->format( 'Y-m-' ) . '%' );
        }, 'feeTransactions.records'] )
            ->getFiltered( $branch_id, $current_class_id, $section_id )
            // if it has any fee_type arrears available
            ->whereHas( 'feeArrears', function ( $query ) {
                $query->where( 'arrear', '>', 0 );
            } );

        // if current_month is selected as report type
        if ( $defaulter_report_type == 'current_month' ) {
            $student_fee_type_monthly_fee_id = Option::getOptionValue( 'student_fee_type_monthly_fee_id' );

            // for current month, if student doesn't have
            // any transactions related to monthly fee for current month
            // those students which have feeTransactions for current month will not be included
            $students->whereDoesntHave( 'feeTransactions', function ( $query ) use ( $now, $student_fee_type_monthly_fee_id ) {
                $query->where( 'created_at', 'like', $now->format( 'Y-m-' ) . '%' );

                // if fee transaction has record with monthly fee id
                $query->whereHas( 'records', function ( $q2 ) use ( $student_fee_type_monthly_fee_id ) {
                    // only selects monthly fee
                    $q2->where( 'student_fee_type_id', $student_fee_type_monthly_fee_id );
                    // to make sure only that transaction is checked which involves student paying amount
                    $q2->where( 'credit', '=', 0 );
                    $q2->where( 'debit', '>', 0 );
                } );
            } );
        }

        $students = $students->get();

        // calculating total arrear for every student
        // separated this part of calculating per student total arrear to filter using this attribute
        for ( $i = 0; $i < count( $students ); $i++ ) {
            $students[$i]->totalArrears = $students[$i]->feeArrears->sum('arrear');
        }

        // if total arrear >= is given and is greater than 0
        if (!empty($greater_than_equal) && $greater_than_equal > 0) {
            $students = $students->where('totalArrears', '>=', $greater_than_equal);
        }
        // if total arrear <= is given and its value is greater than 0
        if (!empty($less_than_equal) && $less_than_equal > 0) {
            $students = $students->where('totalArrears', '<=', $less_than_equal);
        }

        // reindexing student array
        $newStudents = [];
        foreach ($students as $student) {
            $newStudents[] = $student;
        }
        $students = collect($newStudents);

        $totals = [
            'totalArrears' => 0,
            'currentMonthArrears' => 0,
            'students' => [
                'total' => $students->count(),
                'male' => $students->where('gender', '=', 'male')->count(),
                'female' => $students->where('gender', '=', 'female')->count(),
            ],
        ];

        // calculating current month arrears for every student
        for ( $i = 0; $i < count( $students ); $i++ ) {
            // adding total arrear of every student to a overall total arrear
            $totals['totalArrears'] += $students[$i]->totalArrears;

            // calculating current month arrears
            $stdCredit = $students[$i]->feeTransactions->pluck( 'records.*.credit' )->sum( function ( $sm ) {
                return collect( $sm )->sum();
            } );
            $stdDebit = $students[$i]->feeTransactions->pluck( 'records.*.debit' )->sum( function ( $sm ) {
                return collect( $sm )->sum();
            } );
            $stdRemission = $students[$i]->feeTransactions->pluck( 'records.*.remission' )->sum( function ( $sm ) {
                return collect( $sm )->sum();
            } );
            $currentMonthArrears = $stdCredit - ( $stdDebit + $stdRemission );
            $currentMonthArrears = ( $currentMonthArrears < 0 ? 0 : $currentMonthArrears );
            $students[$i]->currentMonthArrears = $currentMonthArrears;
            $totals['currentMonthArrears'] += $currentMonthArrears;
        }
		//$date = date('Y-m-d');
		$date = '2019-12-12';
		$prlist = \DB::table('student_attendances')->where(['student_attendance_type_id' => 1 ,'attendance_date' => $date])->get();
		$prCount = $prlist->count();
		
		$ablist = \DB::table('student_attendances')->where(['student_attendance_type_id' => 2 ,'attendance_date' => $date])->get();
		$abCount = $ablist->count();


		$totals_ab = $abCount;
		$totals_pr = $prCount;
		
		$branchesArr = Branch::get();
			foreach($branchesArr as $branches2){
		
					$brlistm = \DB::table('students')->where(['branch_id' => $branches2->id , 'gender' => 'male' ])->get();
					$ssm[$branches2->id] = $brlistm->count();
					
					$brlistf = \DB::table('students')->where(['branch_id' => $branches2->id , 'gender' => 'female' ])->get();
					$ssf[$branches2->id] = $brlistf->count();
		
				
			}
		
		$totals_male = 0;
		$totals_female = 0;
		
		
		
		
		
		
		
		
	//	public function report(Request $request)
    //{
        $title = "Student Attendance Report";
        $branches_at = Branch::get();
        $classes_at = SchoolClass::get();
        $sections_at = Section::get();
        $student_attendance_types_at = StudentAttendanceType::get();

        $now_at = Carbon::now();

        $branch_id_at = $request->branch_id_at;
        $class_id_at = $request->class_id_at;
        $section_id_at = $request->section_id_at;
        $attendance_date_at = $request->attendance_date_at;
        $attendance_date_at = (empty($attendance_date_at) ? $now->format('d-m-Y') : $attendance_date_at);
        $student_attendance_type_ids_at = $request->student_attendance_type_ids_at;
        $attendance_filter_counts = $request->attendance_filter_counts;
        $date_from_at = $request->date_from;
        $date_to_at = $request->date_to;

        // if attendance date is greater than today's date
        if (Carbon::parse($attendance_date_at) > $now->startOfDay()) {
            return back()->with("err", "Invalid date provided.");
        }

        // student attendance types that are selected. It'll be all if none is selected
        if (!empty($student_attendance_type_ids_at)) {
            $student_attendance_types_selected = $student_attendance_types_at->whereIn('id', $student_attendance_type_ids);
        } else {
            $student_attendance_types_selected = $student_attendance_types_at;
        }

        $branches_statistics = [];
        $branches_statistics_totals = [];
        $class_statistics = [];
        $class_statistics_totals = [];
        $students_at = [];
        $student_statistics = [];

        // if none of branch_id, class_id and section_id is available
        if (empty($branch_id_at) && empty($class_id_at) && empty($section_id_at)) {
            foreach ($branches_at as $k => $branch) {
                $branch_students = $branch->students;

                $branches_statistics[$k] = [
                    'branch' => $branch,
                    'total' => Student::where('branch_id', $branch->id)->count(),
                    'attendance_types' => []
                ];

                foreach ($student_attendance_types_selected as $student_attendance_type) {
                    $branches_statistics[$k]['attendance_types'][] = [
                        'attendance_type' => $student_attendance_type,
                        'count' => StudentAttendance::whereIn('student_id', $branch_students->pluck('id'))->where('student_attendance_type_id', $student_attendance_type->id)->where('attendance_date', Carbon::parse($attendance_date_at))->count()
                    ];
                }
            }

            foreach ($branches_statistics as $branches_statistic) {
                // for adding count of different available attendance types
                foreach ($branches_statistic['attendance_types'] as $attendance_type) {
                    if (isset($branches_statistics_totals[$attendance_type['attendance_type']->name]) && is_numeric($branches_statistics_totals[$attendance_type['attendance_type']->name])) {
                        $branches_statistics_totals[$attendance_type['attendance_type']->name] += $attendance_type['count'];
                    } else {
                        $branches_statistics_totals[$attendance_type['attendance_type']->name] = $attendance_type['count'];
                    }
                }

                // for adding totals of all the attendance types in all the branches
                if (isset($branches_statistics_totals['Total']) && is_numeric($branches_statistics_totals['Total'])) {
                    $branches_statistics_totals['Total'] += $branches_statistic['total'];
                } else {
                    $branches_statistics_totals['Total'] = $branches_statistic['total'];
                }
            }
        } else if (!empty($branch_id_at) && empty($class_id_at) && empty($section_id_at)) { // if branch id is available but other two are not.
            // get class ids from students who are in this selected branch
            $branch_class_ids = Student::where('branch_id', $branch_id_at)->pluck('current_class_id')->unique();
            $branch_classes = SchoolClass::whereIn('id', $branch_class_ids)->get();

            foreach ($branch_classes as $k => $branch_class) {
                $branch_class_students = $branch_class->currentClassStudents;

                $class_statistics[$k] = [
                    'class' => $branch_class,
                    'total' => Student::where('current_class_id', $branch_class->id)->count(),
                    'attendance_types' => []
                ];

                foreach ($student_attendance_types_selected as $student_attendance_type) {
                    $class_statistics[$k]['attendance_types'][] = [
                        'attendance_type' => $student_attendance_type,
                        'count' => StudentAttendance::whereIn('student_id', $branch_class_students->pluck('id'))
                            ->where('student_attendance_type_id', $student_attendance_type->id)
                            ->where('attendance_date', Carbon::parse($attendance_date_at))
                            ->count()
                    ];
                }
            }

            foreach ($class_statistics as $class_statistic) {
                // for adding sub totals of different attendance types
                foreach ($class_statistic['attendance_types'] as $attendance_type) {
                    if (isset($class_statistics_totals[$attendance_type['attendance_type']->name]) && is_numeric($class_statistics_totals[$attendance_type['attendance_type']->name])) {
                        $class_statistics_totals[$attendance_type['attendance_type']->name] += $attendance_type['count'];
                    } else {
                        $class_statistics_totals[$attendance_type['attendance_type']->name] = $attendance_type['count'];
                    }
                }

                // for adding 'total' of all the classes available
                if (isset($class_statistics_totals['Total']) && is_numeric($class_statistics_totals['Total'])) {
                    $class_statistics_totals['Total'] += $class_statistic['total'];
                } else {
                    $class_statistics_totals['Total'] = $class_statistic['total'];
                }
            }
        } else {
            $students_at = Student::with([
                'fatherRecord',
                'attandences' => function ($query) use ($student_attendance_type_ids_at, $attendance_date_at) {
                    if (!empty($student_attendance_type_ids_at)) {
                        $query->whereIn('student_attendance_type_id', $student_attendance_type_ids_at);
                    }
                    $query->where('attendance_date', Carbon::parse($attendance_date_at));
                },
                'attandences.studentAttendanceType'
            ])->getFiltered($branch_id_at, $class_id_at, $section_id_at);

            if (!empty($student_attendance_type_ids_at)) {
                $students_at->whereHas('attandences', function ($query) use ($student_attendance_type_ids_at, $attendance_date_at) {
                    $query->whereIn('student_attendance_type_id', $student_attendance_type_ids_at);
                    //$query->where( 'attendance_date', Carbon::parse( $attendance_date ) );
                });
            }
            $students_at = $students_at->orderBy('pin', 'asc')->get();

            // for range attendance calculations
            $range_attendances = StudentAttendance::whereIn('student_id', $students_at->pluck('id'));
            if (!empty($date_from)) {
                $range_attendances->where('attendance_date', '>=', Carbon::parse($date_from_at)->toDateString());
            }
            if (!empty($date_to)) {
                $range_attendances->where('attendance_date', '<=', Carbon::parse($date_to_at)->toDateString());
            }
            $range_attendances = $range_attendances->get();
            for ($i = 0; $i < count($students_at); $i++) {
                $range_attendance_counts = [];
                foreach ($student_attendance_types_at as $student_attendance_type) {
                    $range_attendance_counts[] = [
                        'student_attendance_type' => $student_attendance_type,
                        'count' => $range_attendances->where('student_id', $students_at[$i]->id)
                            ->where('student_attendance_type_id', $student_attendance_type->id)
                            ->count()
                    ];
                }
                $students[$i]->range_attendance_counts = $range_attendance_counts;
            }

            // if we have attendance filters from form
            if (!empty($attendance_filter_counts)) {
                $tmpStudents = collect();

                foreach ($students_at as $student) {
                    $keepThisStudent = true;
                    foreach ($student->range_attendance_counts as $range_attendance_count) {
                        foreach ($attendance_filter_counts as $attendance_filter_count) {
                            if ($range_attendance_count['student_attendance_type']->id == intval($attendance_filter_count['student_attendance_type_id'])) {
                                if (!empty($attendance_filter_count['greater_than_equal']) && !empty($attendance_filter_count['less_than_equal'])) {
                                    // count should be between grater than, less than value
                                    // count should not be less than the greater than value
                                    // it should not be greater than less than value
                                    if ($range_attendance_count['count'] < intval($attendance_filter_count['greater_than_equal'])
                                        && $range_attendance_count['count'] > intval($attendance_filter_count['less_than_equal'])) {
                                        $keepThisStudent = false;
                                    }
                                } else if (!empty($attendance_filter_count['greater_than_equal'])) {
                                    // count should not be less than the greater than value
                                    if ($range_attendance_count['count'] < intval($attendance_filter_count['greater_than_equal'])) {
                                        $keepThisStudent = false;
                                    }
                                } else if (!empty($attendance_filter_count['less_than_equal'])) {
                                    // count should not be greater than less than value
                                    if ($range_attendance_count['count'] > intval($attendance_filter_count['less_than_equal'])) {
                                        $keepThisStudent = false;
                                    }
                                }

                                // ids matched, no need to search for more
                                break;
                            }
                        }

                        if ($keepThisStudent == false){
                            break;
                        }
                    }

                    if ($keepThisStudent) {
                        $tmpStudents->push($student);
                    }
                }

                $students_at = $tmpStudents;
            }

            $student_statistics = [
                'total' => $students_at->count()
            ];

            foreach ($student_attendance_types_selected as $student_attendance_type) {
                $student_statistics[$student_attendance_type->name] = StudentAttendance::whereIn('student_id', $students_at->pluck('id'))
                    ->where('student_attendance_type_id', $student_attendance_type->id)
                    ->where('attendance_date', Carbon::parse($attendance_date_at))
                    ->count();
            }
        }

      /*  return view('student_attendance.report', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'class_id',
            'section_id',
            'attendance_date',
            'students',
            'student_attendance_types',
            'student_attendance_type_ids',
            'student_attendance_types_selected',
            'branches_statistics_totals',
            'branches_statistics',
            'class_statistics',
            'class_statistics_totals',
            'student_statistics',
            'date_from',
            'date_to',
            'attendance_filter_counts'
        ));*/
    //}

        return view( 'fee_defaulter_student.index', compact(
            'title',
            'branch_id',
            'current_class_id',
			'class_id',
            'section_id',
            'defaulter_report_type',
            'branches',
            'classes',
            'sections',
            'students',
            'totals',
            'greater_than_equal',
            'less_than_equal',
			'totals_ab',
			'totals_pr',
			'ssm',
			'ssf',
			
			
			'branches_at',
            'classes_at',
            'sections_at',
            'branch_id_at',
            'class_id_at',
            'section_id_at',
            'attendance_date_at',
            'students_at',
            'student_attendance_types_at',
            'student_attendance_type_ids_at',
            'student_attendance_types_selected',
            'branches_statistics_totals',
            'branches_statistics',
            'class_statistics',
            'class_statistics_totals',
            'student_statistics',
            'date_from_at',
            'date_to_at',
            'attendance_filter_counts'
			
			
        ) );
    }
}
