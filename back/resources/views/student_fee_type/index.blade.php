@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Student Fee Types</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-money"></i>
    Student Fee Types
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        @if(Auth::user()->userHasPrivilege('student_fee_type_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pagelines"></i> </span>
                        <h2>Add Student Fee Type </h2>

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

                            <form action="{{ route('dashboard.student_fee.type', ['studentFeeTypeEdit' => $studentFeeTypeEdit->id]) }}" method="post">
                                {{ csrf_field() }}

                                <fieldset>
                                    <div class="form-group">
                                        <label>Student Fee Type Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $studentFeeTypeEdit->name) }}" placeholder="Student Fee Type Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Fee Amount</label>
                                        <input type="number" class="form-control" name="fee" value="{{ old('fee', $studentFeeTypeEdit->fee) }}" placeholder="Fee Amount">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $studentFeeTypeEdit->id !== null ? "Update" : "Create" }}
                                    </button>
                                </div>
                            </form>

                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->
                </div>
                <!-- end widget -->
            </article>
            <!-- WIDGET END -->
        @endif

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">

                <header>
                    <span class="widget-icon"> <i class="fa fa-pagelines"></i> </span>
                    <h2>Student Fee Types </h2>

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
                                        <th>Student Fee Type Name</th>
                                        <th>Fee</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($studentFeeTypes as $studentFeeType)
                                        <tr>
                                            <td>{{ $studentFeeType->name }}</td>
                                            <td>{{ $studentFeeType->fee ?? '' }}</td>
                                            <td>
                                                @if($studentFeeType->editable)
                                                    @if(Auth::user()->userHasPrivilege('student_fee_type_edit'))
                                                        <a class="btn btn-default btn-xs" href="{{ route('dashboard.student_fee.type', ['studentFeeTypeEdit' => $studentFeeType->id]) }}" rel="tooltip" title="Edit Student Fee Type">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @endif

                                                    @if(Auth::user()->userHasPrivilege('student_fee_type_add'))
                                                        <a class="btn btn-danger btn-xs confirm-action-model" href="{{ route('dashboard.student_fee.type.delete', ['studentFeeType' => $studentFeeType->id]) }}"
                                                                rel="tooltip" title="Delete Student Fee Type"
                                                                data-body="Do you really want to delete this fee type? Deleting this will <b>remove corresponding account from students fee</b>. It will also <b>remove corresponding arrears of the student</b>. It will also <b>remove reports of corresponding fee paid</b>.<br>Delete with caution.">
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->
    </div>
@endsection
