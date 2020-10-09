@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Student Fee</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-money"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>Statics</h2>

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

        		<table class="table table-striped table-bordered table-hover dtable">
                                <thead>
                                    <tr>
									<th>Absent </th>
									<th>Present</th>
									</tr>
									<tbody>
										<tr>
											<td>{{ $totals_ab }}</td>
											<td>{{ $totals_pr }}</td>
												
										</tr>
									</tbody>
									
									</thead></table>                
									<br>

											<table width="100%" class="table table-striped table-bordered  "  >
                                <thead>
                                    <tr>
									<th>Section</th>
									<th>Male</th>
									<th>Female</th>
									
									</tr>
									<tbody>
									 @foreach($branches as $branch)
										<tr>
											<td>{{ $branch->name }}</td>
											<td><?php  echo $ssm[$branch->id] ?></td>
											<td><?php  echo $ssf[$branch->id] ?></td>
											
									@endforeach		
									
												
										</tr>
									</tbody>
									
									</thead></table>                
		
		
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
		
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>Search </h2>

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
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="form-control branch" name="branch_id">
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $branch->id == $branch_id ? 'selected':'' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Current Class</label>
                                        <select class="form-control current_class school_class" name="current_class_id">
                                            <option value="">Select Current Class</option>

                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ $class->id == $current_class_id ? 'selected':'' }}>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Section</label>
                                        <select class="form-control section" name="section_id">
                                            <option value="">Select Section</option>

                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ $section->id == $section_id ? 'selected':'' }}>{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Total Arrear >=</label>
                                        <input type="number" class="form-control" name="greater_than_equal" value="{{ $greater_than_equal ?? '' }}" min="0" placeholder="Total Arrear >=">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Total Arrear <=</label>
                                        <input type="number" class="form-control" name="less_than_equal" value="{{ $less_than_equal ?? '' }}" min="0" placeholder="Total Arrear <=">
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div>Defaulter Report type</div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="defaulter_report_type" value="current_month" {{ $defaulter_report_type == 'current_month' ? 'checked' : '' }}> Current Month
                                        </label>

                                        <label>
                                            <input type="radio" name="defaulter_report_type" value="overall" {{ $defaulter_report_type == 'overall' ? 'checked' : '' }}> Overall
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>

                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-users"></i> </span>
                    <h2>Defaulters ({{ $defaulter_report_type == 'overall' ? "Overall" : "Current Month" }}) </h2>

                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <input class="form-control" type="text">
                    </div>

                    <div class="widget-body no-padding">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dtable">
                                <thead>
                                    <tr>
                                        <th colspan="11" class="text-center">Total: {{ $totals['students']['total'] }}, Male: {{ $totals['students']['male'] }}, Female: {{ $totals['students']['male'] }}</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{ $totals['totalArrears'] }}</th>
                                        <th>{{ $totals['currentMonthArrears'] }}</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Select
                                            <br><input type="checkbox" class="select_all_checkbox_js" data-target-selector=".select_checkbox_js">
                                        </th>
                                        <th>PIN</th>
                                        <th>Reg#</th>
                                        <th>Name</th>
                                        <th>Father's Name</th>
                                        <th>Father's Cell</th>
                                        <th>Branch</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Total Arrears</th>
                                        <th>Current Month Arrears</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="text-center">
                                                <input type="checkbox" class="select_checkbox_js" name="student_ids[]" value="{{ $student->id }}">
                                            </td>
                                            <td>{{ $student->pin }}</td>
                                            <td>{{ $student->reg_no }}</td>
                                            <td>
                                                <span class="visible-print">{{ $student->name }}</span>
                                                <a class="hidden-print" href="{{ route('dashboard.student_fee.receive_fee', ['student' => $student->id]) }}">{{ $student->name }}</a>
                                            </td>
                                            <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                            <td>{{ $student->fatherRecord->mobile ?? '' }}</td>
                                            <td>{{ $student->branch->name ?? '' }}</td>
                                            <td>{{ $student->currentClass->name ?? '' }}</td>
                                            <td>{{ $student->section->name ?? '' }}</td>
                                            <td>{{ $student->totalArrears }}</td>
                                            <td>{{ $student->currentMonthArrears }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{ $totals['totalArrears'] }}</th>
                                        <th>{{ $totals['currentMonthArrears'] }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-primary form_checkbox_value_btn" data-checkbox-selector=".select_checkbox_js" data-url="{{ route('dashboard.sms.manual') }}" data-param-name="student_ids" data-entity="students">Send SMS</button>
                        </div>

                    </div>
                </div>
            </div>
        </article>
		
		
		
		
		
		
		



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
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Branch</label>
                                            <select name="branch_id_at" class="form-control">
                                                <option value="">---Select Branch---</option>

                                                @foreach($branches_at as $branch)
                                                    <option value="{{ $branch->id }}" {{ ( $branch_id == $branch->id ? "selected" : "" ) }}>{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Class</label>
                                            <select name="class_id_at" class="form-control">
                                                <option value="">---Select Class---</option>

                                                @foreach($classes_at as $class)
                                                    <option value="{{ $class->id }}" {{ ( $class_id_at == $class->id ? "selected" : "" ) }}>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Section</label>
                                            <select name="section_id_at" class="form-control">
                                                <option value="">---Select Section---</option>

                                                @foreach($sections_at as $section)
                                                    <option value="{{ $section->id }}" {{ ( $section_id == $section->id ? "selected" : "" ) }}>{{ $section->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Attendance Date</label>
                                            <input type="text" class="form-control datepicker" name="attendance_date_at" value="{{ $attendance_date_at ?? '' }}" placeholder="Attendance Date" data-dateformat="dd-mm-yy" data-maxdate="+0d">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <p>Attendance Types</p>
                                        <div class="checkbox">
                                            @foreach($student_attendance_types_at as $student_attendance_type)
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="student_attendance_type_ids_at[]" value="{{ $student_attendance_type->id }}" {{ collect($student_attendance_type_ids_at)->contains($student_attendance_type->id) ? "checked" : "" }}> {{ $student_attendance_type->name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if(!empty($branch_id_at) && !empty($class_id_at))
                                        <div class="clearfix"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Date From</label>
                                                <input type="text" class="form-control datepicker" name="date_from_at" value="{{ $date_from_at ?? '' }}" placeholder="Date From" data-dateformat="dd-mm-yy" data-maxdate="+0d">
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Date To</label>
                                                <input type="text" class="form-control datepicker" name="date_to" value="{{ $date_to_at ?? '' }}" placeholder="Date To" data-dateformat="dd-mm-yy" data-maxdate="+0d">
                                            </div>
                                        </div>

                                        @foreach($student_attendance_types_at as $student_attendance_type)
                                            <input type="hidden" name="attendance_filter_counts[{{ $loop->index }}][student_attendance_type_id]" value="{{ $student_attendance_type->id }}">
                                            <div class="col-sm-2">
                                                <b>{{ $student_attendance_type->name }}</b>
                                                <div class="form-group">
                                                    <label>Greater than equal to</label>
                                                    <input type="number" class="form-control" name="attendance_filter_counts[{{ $loop->index }}][greater_than_equal]" value="{{ $attendance_filter_counts[$loop->index]['greater_than_equal'] }}">
                                                </div>

                                                <div class="form-group">
                                                    <label>Greater than equal to</label>
                                                    <input type="number" class="form-control" name="attendance_filter_counts[{{ $loop->index }}][less_than_equal]" value="{{ $attendance_filter_counts[$loop->index]['less_than_equal'] }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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
		
		  @if( !empty($branches_statistics) )
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Branches Statistics </h2>

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
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Branch</th>

                                            @foreach($student_attendance_types_selected as $student_attendance_type)
                                                <th>{{ $student_attendance_type->name }}</th>
                                            @endforeach

                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($branches_statistics as $branches_statistic)
                                            <tr>
                                                <td>
                                                    <a class="hidden-print" href="{{ route('dashboard.student_attendance.report', ['branch_id' => $branches_statistic['branch']->id]) }}">{{ $branches_statistic['branch']->name }}</a>
                                                    <span class="visible-print">{{ $branches_statistic['branch']->name }}</span>
                                                </td>

                                                @foreach($branches_statistic['attendance_types'] as $attendance_type)
                                                    <td>{{ $attendance_type['count'] }}</td>
                                                @endforeach

                                                <td>{{ $branches_statistic['total'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th colspan="{{ ( count($branches_statistic['attendance_types']) + 2 ) }}" class="text-center">
                                                @foreach($branches_statistics_totals as $k => $branches_statistics_total)
                                                    <b>{{ $k }}:</b> {{ $branches_statistics_total }}{{ $loop->last ? '' : ',' }}
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
        @endif

        @if( !empty($class_statistics) )
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-2">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Classes Statistics </h2>

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
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Class</th>

                                            @foreach($student_attendance_types_selected as $student_attendance_type)
                                                <th>{{ $student_attendance_type->name }}</th>
                                            @endforeach

                                            <th>Total</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($class_statistics as $class_statistic)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('dashboard.student_attendance.report', [ 'branch_id' => $branch_id, 'class_id' => $class_statistic['class']->id ]) }}">{{ $class_statistic['class']->name }}</a>
                                                </td>

                                                @foreach($class_statistic['attendance_types'] as $attendance_type)
                                                    <td>{{ $attendance_type['count'] }}</td>
                                                @endforeach

                                                <td>{{ $class_statistic['total'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th colspan="{{ 2 + count($class_statistic['attendance_types']) }}" class="text-center">
                                                @foreach($class_statistics_totals as $k => $class_statistics_total)
                                                    <b>{{ ucwords($k) }}:</b> {{ $class_statistics_total }}{{ $loop->last ? '' : ',' }}
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
        @endif

        @if( !empty($students_at) )
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-3">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
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
                        <div class="widget-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered table-bordered dtable" data-datatable-message-top="@foreach($student_statistics as $key => $value) <b>{{ ucwords($key) }}:</b> {{ $value }}{{ $loop->last === true ? '' : ', ' }} @endforeach">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                Select<br><input type="checkbox" class="select_all_checkbox_js" data-target-selector=".select_checkbox_js">
                                            </th>
                                            <th>PIN</th>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Father's Name</th>
                                            <th>Attendance<br>
                                                <small>({{ $attendance_date_at }})</small>
                                            </th>
                                           <?php /*?> <th>Date Range Counts</th><?php */?>
                                        </tr>
                                    </thead>

                                    <tbody>
									
                                        @foreach($students_at as $student)
                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox" class="select_checkbox_js" name="student_ids[]" value="{{ $student->id }}">
                                                </td>
                                                <td>{{ $student->pin }}</td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('dashboard.student_attendance.student_report', ['student' => $student->id]) }}">
                                                        {{ $student->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                                <td>{{ ($student->attandences->isNotEmpty() ? $student->attandences->first()->studentAttendanceType->name : "Attendance not marked") }}</td>
                                              <?php /*?>  <td>
                                                    @foreach($student->range_attendance_counts as $range_attendance_count)
                                                        <div>{{ $range_attendance_count['student_attendance_type']->name }}(s): {{ $range_attendance_count['count'] }}</div>
                                                    @endforeach
                                                </td><?php */?>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th colspan="6" class="text-center">
                                                @foreach($student_statistics as $key => $value)
                                                    <b>{{ ucwords($key) }}:</b> {{ $value }}{{ $loop->last === true ? '' : ', ' }}
                                                @endforeach
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-primary form_checkbox_value_btn" data-checkbox-selector=".select_checkbox_js" data-url="{{ route('dashboard.sms.manual') }}" data-param-name="student_ids" data-entity="students">Send SMS</button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @endif
		
    </div>
@endsection