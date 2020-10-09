@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $simpeTitle }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-users"></i>
    {{ $simpeTitle }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Filter</label>
                                        <input type="text" class="form-control" name="filter" value="{{ $filter ?? '' }}" placeholder="Filter with text">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div>Student Type</div>

                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="search_type" value="active" {{ $search_type == 'active' ? 'checked' : '' }}> Active
                                        </label>

                                        <label>
                                            <input type="radio" name="search_type" value="all" {{ $search_type == 'all' ? 'checked' : '' }}> All
                                        </label>

                                        <label>
                                            <input type="radio" name="search_type" value="withdrawn" {{ $search_type == 'withdrawn' ? 'checked' : '' }}> Withdrawn
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

        <div class="col-xs-12 text-center" style="font-style: italic;">
            <p>Click on any image to load all the images.</p>
        </div>

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-users"></i> </span>
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
                            <table class="table table-striped table-bordered table-hover dtable">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="{{ ( Auth::user()->userHasPrivilege(['student_edit'], false) ? 11 : 10 ) }}">Current highest PIN: {{ $highest_pin }}, Total Students: {{ $students_count['total'] }}, Male: {{ $students_count['male'] }}, Female: {{ $students_count['female'] }}</th>
                                    </tr>

                                    <tr>
                                        <th class="text-center">
                                            <div class="hidden-print">
                                                Select
                                                <br><input type="checkbox" class="select_all_checkbox_js" data-target-selector=".select_checkbox_js">
                                            </div>
                                        </th>
                                        <th>PIN</th>
                                        <th>Reg#</th>
                                        <th>Date Of Admission</th>
                                        <th>Student Name / Father Name</th>
                                        <th>Branch / Current Class / Section</th>
                                        <th>Date Of Birth / Gender</th>
                                        <th>Colony / City / Address</th>
                                        <th>Phone</th>
                                        <th>Student Status</th>
                                        <th>Picture</th>

                                        {{--Show column only if any of the given permission is availed to the user--}}
                                        @if( Auth::user()->userHasPrivilege(['student_edit', 'student_withdraw', 'student_attendance_view', 'student_performance_report', 'student_readmission', 'receive_fee', 'character_certificate_print', 'leave_certificate_print'], false) )
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td class="text-center">
                                                <div class="hidden-print">
                                                    <input type="checkbox" class="select_checkbox_js" name="student_ids[]" value="{{ $student->id }}">
                                                </div>
                                            </td>
                                            <td>{{ $student->pin }}</td>
                                            <td>{{ $student->reg_no }}</td>
                                            <td>{{ ( !empty( $student->date_of_admission ) ? $student->date_of_admission->format( 'd-M-Y' ) : "" ) }}</td>
                                            <td>
                                                {{ ( !empty($student->name) ? $student->name : "" ) }}
                                                {{ ( !empty($student->fatherRecord->name) ? "/ " . $student->fatherRecord->name : "" ) }}
                                            </td>
                                            <td>
                                                {{ !empty($student->branch->name) ? $student->branch->name : "NA" }}
                                                / {{ !empty($student->currentClass->name) ? $student->currentClass->name : "NA" }}
                                                / {{ !empty($student->section->name) ? $student->section->name : "NA" }}
                                            </td>
                                            <td>
                                                {{ ( !empty($student->dob) ? $student->dob->toFormattedDateString() : "NA" ) }}
                                                / {{ ( !empty($student->gender) ? $student->gender : "NA" ) }}
                                            </td>
                                            <td>
                                                {{ ( !empty($student->colony)? $student->colony : "NA" ) }}
                                                / {{ ( !empty($student->city)? $student->city : "NA" ) }}
                                                / {{ ( !empty($student->home_street_address)? $student->home_street_address : "NA" ) }}
                                            </td>
                                            <td>{{ (isset($student->fatherRecord) ? $student->fatherRecord->mobile : "") }}</td>
                                            <td>{{ $student->withdrawn == 0 ? 'Active' : 'Withdrawn' }}</td>
                                            <td>
                                                <img class="load_images_on_click cursor_pointer" src="{{ asset($loading_image_path) }}" data-img-url="{{ Storage::url($student->image) }}" style="max-height: 100px;" title="Click on any image to load all the images" rel="tooltip">
                                            </td>

                                            {{--Show column only if any of the given permission is availed to the user--}}
                                            @if( Auth::user()->userHasPrivilege(['student_edit', 'student_withdraw', 'student_attendance_view', 'student_performance_report', 'student_readmission', 'receive_fee', 'character_certificate_print', 'leave_certificate_print'], false) )
                                                <td>
                                                    @if( Auth::user()->userHasPrivilege('receive_fee') )
                                                        <a href="{{ route('dashboard.student_fee.receive_fee', ['student' => $student->id]) }}" class="btn btn-primary btn-margin-bottom-xs" rel="tooltip" title="Receive Fee">
                                                            <i class="fa fa-money"></i> Receive Fee
                                                        </a>
                                                        
                                                        <div class="clearfix"></div>
                                                    @endif

                                                    @if( Auth::user()->userHasPrivilege('student_edit') )
                                                        <a href="{{ route('dashboard.student.admission', ['studentEdit' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Edit student details">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif

                                                        </a>
                                                    @if( $student->withdrawn == 0 && Auth::user()->userHasPrivilege('student_withdraw') )
							<a href="{{ route('dashboard.student_withdraw', ['student' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Withdraw this student">                                                            <i class="fa fa-chain-broken"></i>                                                        
                                                    @endif

                                                    @if( Auth::user()->userHasPrivilege('student_attendance_view') )
                                                        <a href="{{ route('dashboard.student_attendance.student_report', ['student' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Student Attendance Report">
                                                            <i class="fa fa-table"></i>
                                                        </a>
                                                    @endif

                                                    @if( Auth::user()->userHasPrivilege('student_performance_report') )
                                                        <a href="{{ route('dashboard.student_performance.student_report', ['student' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Student Performance Report">
                                                            <i class="fa fa-fighter-jet"></i>
                                                        </a>
                                                    @endif

                                                    @if( $student->withdrawn == 1 && Auth::user()->userHasPrivilege('student_readmission') )
                                                        <a href="{{ route('dashboard.readmission', ['student' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Re-admission of this student">
                                                            <i class="fa fa-chain"></i>
                                                        </a>
                                                    @endif

                                                    {{--TODO: Change everything related to this one and update this section--}}
                                                    {{--@if( Auth::user()->userHasPrivilege('edit_fee_fine_arrears') )--}}
                                                        {{--<a href="{{ route('dashboard.student.edit_fee_fine', ['student' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Edit Fee and Fine Arrears of Student">--}}
                                                            {{--<i class="fa fa-money"></i>--}}
                                                        {{--</a>--}}
                                                    {{--@endif--}}
                                                        
                                                    <div class="clearfix"></div>

                                                    @if( Auth::user()->userHasPrivilege('character_certificate_print') )
                                                        <a href="{{ route('dashboard.character_certificate', ['student_id' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Character Certificate">
                                                            <i class="fa fa-user"></i> Character Certificate
                                                        </a>

                                                        <div class="clearfix"></div>
                                                    @endif

                                                    @if( Auth::user()->userHasPrivilege('leave_certificate_print') )
                                                        <a href="{{ route('dashboard.leave_certificate', ['student_id' => $student->id]) }}" class="btn btn-default btn-xs btn-margin-bottom-xs" rel="tooltip" title="Leave Certificate">
                                                            <i class="fa fa-user"></i> Leave Certificate
                                                        </a>

                                                        <div class="clearfix"></div>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            @if($permissions['update_assigned_student_class_fee'])
                                <button type="button" class="btn btn-default form_checkbox_value_btn" data-checkbox-selector=".select_checkbox_js" data-url="{{ route('dashboard.class.update_assigned_class_fee') }}" data-param-name="student_ids" data-entity="students">Update Assigned Class Fee</button>
                            @endif
                            @if($permissions['send_manual_sms'])
                                <button type="button" class="btn btn-default form_checkbox_value_btn" data-checkbox-selector=".select_checkbox_js" data-url="{{ route('dashboard.sms.manual') }}" data-param-name="student_ids" data-entity="students">Send SMS</button>
                            @endif
                            <button type="button" class="btn btn-default form_checkbox_value_btn" data-checkbox-selector=".select_checkbox_js" data-url="{{ route('dashboard.student_fee.assign') }}" data-param-name="student_ids" data-entity="students">Assign Fee</button>
                            <button type="button" class="btn btn-default form_checkbox_value_btn" data-checkbox-selector=".select_checkbox_js" data-url="{{ route('dashboard.student.card.print') }}" data-param-name="student_ids" data-entity="students">Print Cards</button>
                            @if(!empty($current_class_id) && $permissions['promote_demote_student'])
                                <button type="button" class="btn btn-default form_checkbox_value_btn" data-checkbox-selector=".select_checkbox_js" data-url="{{ route('dashboard.student.promote_demote') }}" data-param-name="student_ids" data-entity="students">Promote/Demote Students</button>
                            @endif
                        </div>

                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
    </div>
@endsection