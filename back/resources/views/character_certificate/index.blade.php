@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-user"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-5 col-md-4 col-lg-4">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0" data-widget-deletebutton="false">

                <header>
                    <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                    <h2>Character Certificate Details </h2>

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
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $student->name }}</td>
                                </tr>

                                <tr>
                                    <th>Father's Name</th>
                                    <td>{{ $student->fatherRecord->name ?? "" }}</td>
                                </tr>

                                <tr>
                                    <th>Branch</th>
                                    <td>{{ $student->branch->name ?? "" }}</td>
                                </tr>

                                <tr>
                                    <th>Class</th>
                                    <td>{{ $student->currentClass->name ?? "" }}</td>
                                </tr>

                                <tr>
                                    <th>Section</th>
                                    <td>{{ $student->section->name ?? '' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <form action="{{ route('dashboard.character_certificate.print') }}" method="post">
                            {{ csrf_field() }}

                            <input type="hidden" name="student_id" value="{{ $student->id }}">

                            <fieldset>
                                <div class="form-group">
                                    <label>PIN</label>
                                    <input type="text" class="form-control" name="pin" value="{{ old('pin', $student->pin) }}" placeholder="PIN" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Conduct</label>
                                    <input type="text" class="form-control" name="conduct" value="{{ old('conduct') }}" placeholder="Conduct" required>
                                </div>

                                <div class="form-group">
                                    <label>Remarks</label>
                                    <textarea class="form-control" name="remarks" rows="5" placeholder="Remarks regarding student">{{ old('remarks') }}</textarea>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Generate Character Certificate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection