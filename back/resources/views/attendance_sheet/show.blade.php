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
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>Attendance Sheet For </h2>

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

                        <form action="{{ route('dashboard.attendance_sheet.print') }}" method="get">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select class="form-control branch" name="branch_id" required>
                                            <option value="">Select Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ $branch->id == $branch_id ? 'selected':'' }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Current Class</label>
                                        <select class="form-control current_class school_class" name="current_class_id" required>
                                            <option value="">Select Current Class</option>

                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ $class->id == $current_class_id ? 'selected':'' }}>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Section</label>
                                        <select class="form-control section" name="section_id" required>
                                            <option value="">Select Section</option>

                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ $section->id == $section_id ? 'selected':'' }}>{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Get Attendance Sheet</button>
                            </div>
                        </form>

                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
    </div>
@endsection