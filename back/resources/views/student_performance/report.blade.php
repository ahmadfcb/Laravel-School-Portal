@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Performance</li>
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
                                    <div class="col-sm-2">
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

                                    <div class="col-sm-2">
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

                                    <div class="col-sm-2">
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
                                            <label>Date From</label>
                                            <input type="text" class="form-control datepicker" name="date_from" value="{{ $date_from->format('d-m-Y') }}" placeholder="Date From" data-dateformat="dd-mm-yy">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <input type="text" class="form-control datepicker" name="date_to" value="{{ $date_to->format('d-m-Y') }}" placeholder="Date To" data-maxdate="+0d">
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

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
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
                            <table class="table table-bordered table-bordered dtable">
                                <thead>
                                    <tr>
                                        <th>PIN</th>
                                        <th>Reg#</th>
                                        <th>Sr. No.</th>
                                        <th>Name</th>
                                        <th>Father's Name</th>
                                        <th>Performances</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->pin }}</td>
                                            <td>{{ $student->reg_no }}</td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a class="hidden-print" href="{{ route('dashboard.student_performance.student_report', ['student' => $student->id]) }}" rel="tooltip" title="Open Student's Performance">
                                                    {{ $student->name }}
                                                </a>
                                                <span class="visible-print">{{ $student->name }}</span>
                                            </td>
                                            <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                            <td>
                                                @foreach($student->cus_performances as $cus_performance)
                                                    <div style="margin-bottom: 5px;">
                                                        {{ $cus_performance['performance_type_name'] }}:

                                                        <span class="visible-print">{{ round($cus_performance['performance_scale_weight_avg']) }}</span>

                                                        @for($i = 0; $i < round($cus_performance['performance_scale_weight_avg']); $i++)
                                                            <i class="fa fa-star"></i>
                                                        @endfor
                                                    </div>
                                                @endforeach

                                                <div>
                                                    <b>Overall AVG</b>:

                                                    <span class="visible-print">{{ round($student->cus_performances->avg('performance_scale_weight_avg')) }}</span>
                                                    
                                                    @for($i = 0; $i < round($student->cus_performances->avg('performance_scale_weight_avg')); $i++)
                                                        <i class="fa fa-star"></i>
                                                    @endfor
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection