@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Attendance</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-table"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Filter </h2>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                        <input class="form-control" type="text">
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <form action="{{ url()->current() }}" method="get">
                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Branch</label>
                                            <select name="branch_id" class="form-control">
                                                <option value="">---Select Branch---</option>

                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ ( $branch_id == $branch->id ? "selected" : "" ) }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Class</label>
                                            <select name="class_id" class="form-control">
                                                <option value="">---Select Class---</option>

                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ ( $class_id == $class->id ? "selected" : "" ) }}>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Section</label>
                                            <select name="section_id" class="form-control">
                                                <option value="">---Select Section---</option>

                                                @foreach($sections as $section)
                                                    <option value="{{ $section->id }}" {{ ( $section_id == $section->id ? "selected" : "" ) }}>{{ $section->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Attendance Date</label>
                                            <input type="text" class="form-control datepicker" name="attendance_date" value="{{ $attendance_date ?? '' }}" placeholder="Attendance Date" data-dateformat="dd-mm-yy" data-maxdate="+0d" required>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>


        @if(!empty($students))

            @if($attendanceExists)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <p>Students' attendance for {{ $attendance_date }} has already been marked!</p>

                    @if($attendanceEditPrivilege === false)
                        <p class="text-danger">You don't have privilege to update this attendance.</p>
                    @endif
                </div>
            @endif

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                        <h2>Students </h2>

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form action="{{ route('dashboard.student_attendance') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="attendance_date" value="{{ $attendance_date }}">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>PIN</th>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Father's Name</th>
                                                <th>Attendance</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($students as $student)
                                                <tr>
                                                    <td>{{ $student->pin }}</td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                                    <td>
                                                        <input type="hidden" name="students[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                                        <div class="radio">
                                                            @foreach($student_attendance_types as $student_attendance_type)
                                                                <label class="radio-inline">
                                                                    <input type="radio" name="students[{{ $loop->parent->index }}][student_attendance_type_id]" value="{{ $student_attendance_type->id }}" {{ ( old("students[{$loop->parent->iteration}][student_attendance_type_id]") ?? $student->attendance($attendance_date)->student_attendance_type_id ?? $default_student_attendance_type->value ?? '' ) == $student_attendance_type->id ? "checked" : "" }} {{ ($attendanceExists === true && $attendanceEditPrivilege === false ? "disabled" : "") }}> {{ $student_attendance_type->name }}
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-actions">
                                    @if($attendanceExists)
                                        @if($attendanceEditPrivilege === false)
                                            <button type="button" class="btn btn-primary" disabled>You cannot edit Attendance</button>
                                        @else
                                            <button type="submit" class="btn btn-primary">Update Attendance</button>
                                        @endif
                                    @else
                                        <button type="submit" class="btn btn-primary" name="attendance_submit" value="mark">Mark Attendance</button>
                                        <button type="submit" class="btn btn-primary" name="attendance_submit" value="mark_and_sms">Mark Attendance & open SMS for absent</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @endif

    </div>
@endsection