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
        <article class="col-xs-12 col-sm-7 col-sm-push-5 col-md-7 col-md-push-5 col-lg-8 col-lg-push-4">
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <input type="text" class="form-control datepicker" name="date_from" value="{{ ( !empty($date_from) ? $date_from->format('d-m-Y') : '' ) }}" placeholder="Date From" data-dateformat="dd-mm-yy">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <input type="text" class="form-control datepicker" name="date_to" value="{{ ( !empty($date_to) ? $date_to->format('d-m-Y') : '' ) }}" placeholder="Date To" data-dateformat="dd-mm-yy">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <p>Attendance Types</p>
                                        <div class="checkbox">
                                            @foreach($student_attendance_types as $student_attendance_type)
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="student_attendance_type_ids[]" value="{{ $student_attendance_type->id }}" {{ collect($student_attendance_type_ids)->contains($student_attendance_type->id) ? "checked" : "" }}> {{ $student_attendance_type->name }}
                                                </label>
                                            @endforeach
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

        <article class="col-xs-12 col-sm-5 col-sm-pull-7 col-md-5 col-md-pull-7 col-lg-4 col-lg-pull-8">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Student Details </h2>

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
                    <div class="widget-body no-padding">

                        <div>
                            <img src="{{ Storage::url($student->image) }}" alt="{{ $student->name }}" class="img-responsive center-block" style="max-height: 150px;">
                        </div>

                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>PIN</th>
                                    <td>{{ $student->pin }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $student->name }}</td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Branch</th>
                                    <td>{{ $student->branch->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Class</th>
                                    <td>{{ $student->currentClass->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Section</th>
                                    <td>{{ $student->section->name ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </article>

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>Student Attendances </h2>

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
                    <div class="widget-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dtable" data-datatable-message-top="@foreach($student_attendance_statistics as $k => $attendance_statistic) {{ $k }}: {{ $attendance_statistic }}{{ ( $loop->last ? "" : ", " ) }} @endforeach" data-datatable-message-bottom="@foreach($student_attendance_statistics as $k => $attendance_statistic) {{ $k }}: {{ $attendance_statistic }}{{ ( $loop->last ? "" : ", " ) }} @endforeach">
                                <thead>
                                    <tr>
                                        <th>Attendance Date</th>
                                        <th>Attendance Type</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($student_attendances as $student_attendance)
                                        <tr>
                                            <td>{{ $student_attendance->attendance_date->format('d-m-Y') }}</td>
                                            <td>{{ $student_attendance->studentAttendanceType->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-center">
                                            @foreach($student_attendance_statistics as $k => $attendance_statistic)
                                                {{ $k }}: {{ $attendance_statistic }}{{ ( $loop->last ? "" : ", " ) }}
                                            @endforeach
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection