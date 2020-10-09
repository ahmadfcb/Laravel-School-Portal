@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-users"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="text-center" style="margin-bottom: 10px;">
        @if($previousStudent !== null)
            <a href="{{ route('dashboard.student.edit_fee_fine', ['student' => $previousStudent->id]) }}" class="btn btn-default" rel="tooltip" title="Previous Student">
                <i class="fa fa-chevron-left"></i> Previous Student
            </a>
        @endif

        @if($nextStudent !== null)
            <a href="{{ route('dashboard.student.edit_fee_fine', ['student' => $nextStudent->id]) }}" class="btn btn-default" rel="tooltip" title="Next Student">
                <i class="fa fa-chevron-right"></i> Next Student
            </a>
        @endif
    </div>

    <div class="row">
        <article class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>Fee and Fine Arrears </h2>

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
                        <p class="help-block">This section contains all the previous remaining fee and fine for a student. Edit it carefully!</p>

                        <form action="{{ route('dashboard.student.edit_fee_fine.save_fee_fine_arrears', ['student' => $student->id]) }}" method="post" onsubmit="return confirm('Do you really want to update this fee and fine information? It will not be reversible.');">
                            {{ csrf_field() }}

                            <fieldset>
                                <div class="form-group">
                                    <label>Total Fee Arrears</label>
                                    <input type="number" class="form-control" name="total_fee_arrears" value="{{ $student->total_fee_arrears }}" min="0" placeholder="Student Fee Arrears">
                                </div>

                                <div class="form-group">
                                    <label>Total Fine Arrears</label>
                                    <input type="number" class="form-control" name="total_fine_arrears" value="{{ $student->total_fine_arrears }}" min="0" placeholder="Total Fine Arrears">
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>

        <article class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>Student Information </h2>

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
                        <div class="text-center">
                            <img src="{{ Storage::url($student->image) }}" alt="{{ $student->name }}" style="width: 100%; max-width: 150px;">
                        </div>
                        
                        <div class="table-responsive">
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
            </div>
        </article>
    </div>
@endsection