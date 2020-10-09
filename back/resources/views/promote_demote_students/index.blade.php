@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Student</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-users"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>Selected Students </h2>

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
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>PIN</th>
                                        <th>Name</th>
                                        <th>Father's Name</th>
                                        <th>Branch</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->pin ?? '' }}</td>
                                            <td>{{ $student->name ?? '' }}</td>
                                            <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                            <td>{{ $student->branch->name ?? '' }}</td>
                                            <td>{{ $student->currentClass->name ?? '' }}</td>
                                            <td>{{ $student->section->name ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <article class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>Promote/Demote </h2>

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
                        <form action="{{ route('dashboard.student.promote_demote') }}" method="post">
                            {{ csrf_field() }}
                            @foreach($students as $student)
                                <input type="hidden" name="students[{{ $loop->index }}]" value="{{ $student->id }}">
                            @endforeach

                            <fieldset>
                                <div class="form-group">
                                    <label>Branches</label>
                                    <select name="branch" class="form-control">
                                        <option value="">---Select Branch---</option>

                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}" {{ old('branch') }}>{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Classes</label>
                                    <select name="class" class="form-control">
                                        <option value="">---Select Class---</option>

                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class') }}>{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Section</label>
                                    <select name="section" class="form-control">
                                        <option value="">---Select Section---</option>

                                        @foreach($sections as $section)
                                            <option value="{{ $section->id }}" {{ old('section') }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Promote/Demote</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection