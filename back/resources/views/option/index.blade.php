@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-tags"></i>
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
                    <span class="widget-icon"> <i class="fa fa-tags"></i> </span>
                    <h2>Options </h2>

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
                        <form action="{{ route('dashboard.option') }}" method="post">
                            {{ csrf_field() }}

                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label>Default Student Attendance</label>
                                            <select name="default_student_attendance_type" class="form-control" required>
                                                <option value="">---Select Default Student Attendance---</option>

                                                @foreach($student_attendance_types as $student_attendance_type)
                                                    <option value="{{ $student_attendance_type->id }}" {{ ( ($default_student_attendance_type->value ?? '') == $student_attendance_type->id ? "selected" : "") }}>{{ $student_attendance_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label>Fee Submission Due Date <small>(Of every month)</small></label>
                                            <select name="fee_submission_due_date" class="form-control" required>
                                                @for($i=1; $i<=25; $i++)
                                                    <option value="{{ $i }}" {{ old('fee_submission_due_date', $fee_submission_due_date->value) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label>Fine on fee after due date</label>
                                            <input type="number" class="form-control" name="fee_fine_after_due_date" value="{{ old('fee_fine_after_due_date', $fee_fine_after_due_date->value) }}" min="0" placeholder="Fine on fee after due date" required>
                                        </div>
                                    </div>

                                    {{--Showing after 3 columns on small screen--}}
                                    <div class="clearfix visible-sm"></div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label>Allow automatic fee generation</label>
                                            <select name="allow_automatic_fee_generate" class="form-control" required>
                                                <option value="1" {{ old('allow_automatic_fee_generate', $allow_automatic_fee_generate->value) == '1' ? 'selected' : '' }}>Continue Generating</option>
                                                <option value="0" {{ old('allow_automatic_fee_generate', $allow_automatic_fee_generate->value) == '0' ? 'selected' : '' }}>Pause</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{--Showing after 4 solumns on medium screen--}}
                                    <div class="clearfix visible-md"></div>
                                    <div class="clearfix visible-lg"></div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label>SMS template on admission</label>
                                            <select name="sms_on_admission" class="form-control" required>
                                                <option value="">---Select an SMS from template---</option>

                                                @foreach($smsTemplates as $smsTemplate)
                                                    <option value="{{ $smsTemplate->id }}" {{ old('sms_on_admission', $sms_on_admission->value) == $smsTemplate->id ? 'selected' : '' }}>{{ $smsTemplate->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label>Default Performance Scale</label>
                                            <select name="default_performance_scale_id" class="form-control" required>
                                                <option value="">---Default Performance Scale---</option>

                                                @foreach($performance_scales as $performance_scale)
                                                    <option value="{{ $performance_scale->id }}" {{ old('default_performance_scale_id', $default_performance_scale_id->value) == $performance_scale->id ? 'selected' : '' }}>{{ $performance_scale->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-md-3">
                                        <label>Send automatic SMS</label>
                                        <div class=""> {{--.checkbox class--}}
                                            <label>
                                                <input type="checkbox" name="send_automatic_sms" value="1" class="checkbox style-0" {{ old('send_automatic_sms', $send_automatic_sms->value ?? '') == 1 ? 'checked' : '' }}>
                                                <span>Enable</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection