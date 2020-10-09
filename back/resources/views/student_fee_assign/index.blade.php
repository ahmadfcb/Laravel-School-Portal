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
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">

                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>PIN</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->pin }}</td>
                                            <td>{{ $student->name }}</td>
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

        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">

                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
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
                        <form action="{{ route('dashboard.student_fee.assign') }}" method="post">
                            {{ csrf_field() }}

                            @foreach($students as $student)
                                <input type="hidden" name="student_ids[{{ $loop->index }}]" value="{{ $student->id }}">
                            @endforeach

                            <fieldset>
                                <p>Fee</p>

                                @foreach($studentFeeTypes as $studentFeeType)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="studentFeeTypes[{{ $loop->index }}]" value="{{ $studentFeeType->id }}"> {{ $studentFeeType->name }}: {{ $studentFeeType->fee }}
                                        </label>
                                    </div>
                                @endforeach
                            </fieldset>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection