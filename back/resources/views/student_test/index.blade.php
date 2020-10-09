@extends ("layouts.main")
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
                                            @foreach($branch as $branch)
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
                                                 @foreach($class as $class)
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
                                                 @foreach($section as $section)
                                                    <option value="{{ $section->id }}" {{ ( $section_id == $section->id ? "selected" : "" ) }}>{{ $section->name }}</option>
                                                @endforeach
                                           
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Test Date</label>
                                            <input type="text" class="form-control datepicker" name="attendance_date" value="{{ $attendance_date ?? '' }}" placeholder="Attendance Date" data-dateformat="dd-mm-yy" data-maxdate="+0d">
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Test Type</label>
                                            <select name="section_id" class="form-control">
                                                <option value="">---Select Test---</option>
                                                 @foreach($type as $type)
                                                    <option value="{{ $type->id }}" {{ ( $test_id == $type->id ? "selected" : "" ) }}>{{ $type->testType }}</option>
                                                @endforeach
                                           
                                            </select>
                                        </div>
                                    </div>



                                     
         
                            </fieldset>

                            <div class="form-actions">
                               
                                <button type="button" onclick="window.location='{{ route("dashboard.reports") }}'">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>

@stop 