<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Option;
use App\SchoolClass;
use App\Section;
use App\Student;
use App\StudentAttendance;
use App\StudentAttendanceType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentAttendanceController extends Controller
{
    public function __construct()
    {
        //$this->middleware( 'auth' );
        $this->middleware('CheckPrivilege:student_attendance_mark')->only(['index', 'markAttendance']);
        $this->middleware('CheckPrivilege:student_attendance_view')->only(['report', 'studentReport']);
    }

    public function attendanceValidator(array $data)
    {
        $rules = [
            'students' => 'required',
            'students.*.student_id' => 'required|numeric|exists:students,id',
            'students.*.student_attendance_type_id' => 'required|numeric|exists:student_attendance_types,id',
            'attendance_date' => 'required|date',
            'attendance_submit' => 'nullable|in:mark,mark_and_sms',
        ];

        return \Validator::make($data, $rules);
    }

    public function index(Request $request)
    {
        $title = "Student Attendance";
        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();
        $student_attendance_types = StudentAttendanceType::get();

        $branch_id = $request->branch_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $attendance_date = $request->attendance_date;
        $attendance_date = (empty($attendance_date) ? Carbon::now()->format('d-m-Y') : $attendance_date);

        $user = \Auth::user();
        $attendanceEditPrivilege = $user->userHasPrivilege('student_attendance_edit');

        // if attendance date is greater than today's date
        if (Carbon::parse($attendance_date) > Carbon::now()->startOfDay()) {
            return back()->with('err', "Invalid date provided.");
        }

        $students = [];
        $attendanceExists = false;
        if (!empty($branch_id) || !empty($class_id) || !empty($section_id)) {
            // getting students
            $students = Student::with(['fatherRecord', 'attandences'])
                ->getFiltered($branch_id, $class_id, $section_id)
                ->orderBy('pin', 'asc')
                ->get();

            // checking whether there is some attendance for the selected students
            $attendanceExists = StudentAttendance::whereIn('student_id', $students->pluck('id'))->where('attendance_date', Carbon::parse($attendance_date))->count();
            $attendanceExists = ($attendanceExists > 0 ? true : false);
        }

        $default_student_attendance_type = Option::find('default_student_attendance_type');

        return view('student_attendance.index', compact(
            'title',
            'branches',
            'classes',
            'sections',
            'branch_id',
            'class_id',
            'section_id',
            'students',
            'student_attendance_types',
            'default_student_attendance_type',
            'attendance_date',
            'attendanceExists',
            'attendanceEditPrivilege'
        ));
    }

    public function markAttendance(Request $request)
    {
        // validating request
        $this->attendanceValidator($request->all())->validate();

        $students = $request->students;
        $attendance_date = $request->attendance_date;
        $attendance_submit = $request->attendance_submit;

        // get all the student ids
        $student_ids = [];
        foreach ($students as $student) {
            $student_ids[] = $student['student_id'];
        }

        // check if attendance has already been marked
        // and user doesn't have privilege to update the attendance
        if (StudentAttendance::whereIn('student_id', $student_ids)->where('attendance_date', Carbon::parse($attendance_date))->count() > 0 && \Auth::user()->userHasPrivilege('student_attendance_edit') === false) {
            return back()->with('err', "You don't have privilege to update the already marked Attendance.");
        }

        try {
            $absent_attendance_type_id = Option::getOptionValue('absent_attendance_type_id');

            $absentStudentIds = \DB::transaction(function () use ($students, $attendance_date, $absent_attendance_type_id) {
                $absentStudentIds = [];

                foreach ($students as $student) {
                    $studentAttendance = StudentAttendance::firstOrNew([
                        'student_id' => $student['student_id'],
                        'attendance_date' => Carbon::parse($attendance_date)
                    ]);
                    $studentAttendance->student_attendance_type_id = $student['student_attendance_type_id'];
                    $studentAttendance->save();

                    // if attendance type provided matches to that of absent attendance type
                    if ($student['student_attendance_type_id'] == $absent_attendance_type_id) {
                        $absentStudentIds[] = $student['student_id'];
                    }
                }

                return $absentStudentIds;
            });

            // if attendance_submit is mark_and_sms
            if ($attendance_submit == 'mark_and_sms') {
                return redirect()->route('dashboard.sms.manual', ['student_ids' => implode(',', $absentStudentIds)]);
            } else {
                return back()->with('msg', 'Attendance has been marked');
            }
        } catch (\Exception $exception) {
            $log_msg = "Student's attendance wasn't marked successfully!";
            $log_msg .= "\nError message: {$exception->getMessage()}";
            $log_msg .= "\nLogged in User:";
            $log_msg .= "\n\tUser id = " . auth()->user()->id;
            $log_msg .= "\n\tUser email = " . auth()->user()->email;
            \Log::warning($log_msg, ['error_trace' => $exception->getTraceAsString()]);

            return back()->with('err', "Something went wrong. Please try again.");
        }
    }

    public function report(Request $request)
    {
        $title = "Student Attendance Report";
        $branches = Branch::get();
        $classes = SchoolClass::get();
        $sections = Section::get();
        $student_attendance_types = StudentAttendanceType::get();

        $now = Carbon::now();

        $branch_id = $request->branch_id;
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $attendance_date = $request->attendance_date;
        $attendance_date = (empty($attendance_date) ? $now->format('d-m-Y') : $attendance_date);
        $student_attendance_type_ids = $request->student_attendance_type_ids;
        $attendance_filter_counts = $request->attendance_filter_counts;
        $date_from = $request->date_from;
        $date_to = $request->date_to;

        // if attendance date is greater than today's date
        if (Carbon::parse($attendance_date) > $now->startOfDay()) {
            return back()->with("err", "Invalid date provided.");
        }

        // student attendance types that are selected. It'll be all if none is selected
        if (!empty($student_attendance_type_ids)) {
            $student_attendance_types_selected = $student_attendance_types->whereIn('id', $student_attendance_type_ids);
        } else {
            $student_attendance_types_selected = $student_attendance_types;
        }

        $branches_statistics = [];
        $branches_statistics_totals = [];
        $class_statistics = [];
        $class_statistics_totals = [];
        $students = [];
        $student_statistics = [];

        // if none of branch_id, class_id and section_id is available
        if (empty($branch_id) && empty($class_id) && empty($section_id)) {
            foreach ($branches as $k => $branch) {
                $branch_students = $branch->students;

                $branches_statistics[$k] = [
                    'branch' => $branch,
                    'total' => Student::where('branch_id', $branch->id)->count(),
                    'attendance_types' => []
                ];

                foreach ($student_attendance_types_selected as $student_attendance_type) {
                    $branches_statistics[$k]['attendance_types'][] = [
                        'attendance_type' => $student_attendance_type,
                        'count' => StudentAttendance::whereIn('student_id', $branch_students->pluck('id'))->where('student_attendance_type_id', $student_attendance_type->id)->where('attendance_date', Carbon::parse($attendance_date))->count()
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
        } else if (!empty($branch_id) && empty($class_id) && empty($section_id)) { // if branch id is available but other two are not.
            // get class ids from students who are in this selected branch
            $branch_class_ids = Student::where('branch_id', $branch_id)->pluck('current_class_id')->unique();
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
                            ->where('attendance_date', Carbon::parse($attendance_date))
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
            $students = Student::with([
                'fatherRecord',
                'attandences' => function ($query) use ($student_attendance_type_ids, $attendance_date) {
                    if (!empty($student_attendance_type_ids)) {
                        $query->whereIn('student_attendance_type_id', $student_attendance_type_ids);
                    }
                    $query->where('attendance_date', Carbon::parse($attendance_date));
                },
                'attandences.studentAttendanceType'
            ])->getFiltered($branch_id, $class_id, $section_id);

            if (!empty($student_attendance_type_ids)) {
                $students->whereHas('attandences', function ($query) use ($student_attendance_type_ids, $attendance_date) {
                    $query->whereIn('student_attendance_type_id', $student_attendance_type_ids);
                    //$query->where( 'attendance_date', Carbon::parse( $attendance_date ) );
                });
            }
            $students = $students->orderBy('pin', 'asc')->get();

            // for range attendance calculations
            $range_attendances = StudentAttendance::whereIn('student_id', $students->pluck('id'));
            if (!empty($date_from)) {
                $range_attendances->where('attendance_date', '>=', Carbon::parse($date_from)->toDateString());
            }
            if (!empty($date_to)) {
                $range_attendances->where('attendance_date', '<=', Carbon::parse($date_to)->toDateString());
            }
            $range_attendances = $range_attendances->get();
            for ($i = 0; $i < count($students); $i++) {
                $range_attendance_counts = [];
                foreach ($student_attendance_types as $student_attendance_type) {
                    $range_attendance_counts[] = [
                        'student_attendance_type' => $student_attendance_type,
                        'count' => $range_attendances->where('student_id', $students[$i]->id)
                            ->where('student_attendance_type_id', $student_attendance_type->id)
                            ->count()
                    ];
                }
                $students[$i]->range_attendance_counts = $range_attendance_counts;
            }

            // if we have attendance filters from form
            if (!empty($attendance_filter_counts)) {
                $tmpStudents = collect();

                foreach ($students as $student) {
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

                $students = $tmpStudents;
            }

            $student_statistics = [
                'total' => $students->count()
            ];

            foreach ($student_attendance_types_selected as $student_attendance_type) {
                $student_statistics[$student_attendance_type->name] = StudentAttendance::whereIn('student_id', $students->pluck('id'))
                    ->where('student_attendance_type_id', $student_attendance_type->id)
                    ->where('attendance_date', Carbon::parse($attendance_date))
                    ->count();
            }
        }

        return view('student_attendance.report', compact(
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
        ));
    }

    public function studentReport(Request $request, Student $student)
    {
        $this->validate($request, [
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'student_attendance_type_ids' => 'nullable',
            'student_attendance_type_ids.*' => 'numeric|exists:student_attendance_types,id'
        ]);

        $student->load(['fatherRecord', 'branch', 'currentClass', 'section']);

        $title = "{$student->name}'s Attendance Report";

        $date_from = $request->date_from;
        $date_from = (!empty($date_from) ? Carbon::parse($date_from) : Carbon::now()->subMonth(1));

        $date_to = $request->date_to;
        $date_to = (!empty($date_to) ? Carbon::parse($date_to) : Carbon::now());

        $student_attendance_type_ids = $request->student_attendance_type_ids;

        $student_attendance_types = StudentAttendanceType::get();

        $student_attendances = StudentAttendance::with(['studentAttendanceType'])->where([
            ['student_id', '=', $student->id],
            ['attendance_date', '>=', $date_from],
            ['attendance_date', '<=', $date_to]
        ]);
        if (!empty($student_attendance_type_ids)) {
            $student_attendances->whereIn('student_attendance_type_id', $student_attendance_type_ids);
        }
        $student_attendances = $student_attendances->get();

        $student_attendance_statistics = [];
        foreach ($student_attendance_types as $student_attendance_type) {
            $student_attendance_statistics[$student_attendance_type->name] = $student_attendances->where('student_attendance_type_id', '=', $student_attendance_type->id)->count();
        }

        return view('student_attendance.student_report', compact(
            'title',
            'date_from',
            'date_to',
            'student_attendance_type_ids',
            'student',
            'student_attendance_types',
            'student_attendances',
            'student_attendance_statistics'
        ));
    }
}
