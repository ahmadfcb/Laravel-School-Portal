@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Student Fee</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-money"></i>
    {{ $title }}
    @if($date_diff_days > 0)
        -
        <small>({{ $date_diff }} interval)</small>
    @endif
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                    <h2>Filter Transactions </h2>

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

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Date From</label>
                                            <input type="text" class="form-control datepicker" name="date_from" value="{{ old('date_from', $date_from->format('d-m-Y')) }}" placeholder="Date From" data-dateformat="dd-mm-yy">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label>Date To</label>
                                            <input type="text" class="form-control datepicker" name="date_to" value="{{ old('date_to', $date_to->format('d-m-Y')) }}" placeholder="Date To" data-dateformat="dd-mm-yy">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <p>Restrict Transactions Type</p>

                                        <div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="checkbox style-0" name="add_transaction" value="1" {{ $add_transaction == 1 ? 'checked' : '' }}>
                                                    <span>Added Arrears</span>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="checkbox style-0" name="deposit_transactions" value="1" {{ $deposit_transactions == 1 ? 'checked' : '' }}>
                                                    <span>Paid by Students</span>
                                                </label>
                                            </div>
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

        @if($statistics['show_branches_stats'] === true || $statistics['show_class_stats'] === true || $statistics['show_section_stats'] === true)
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-2" data-widget-collapsed="{{ ($expand_stats === true ? 'false' : 'true') }}">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Statistics </h2>

                    </header>

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
                                @if($statistics['show_branches_stats'] === true)
                                    <table class="table table-bordered table-striped dtable">
                                        <thead>
                                            <tr>
                                                <th>Branch</th>
                                                <th>Students Paid <small>(Within selected interval)</small></th>
                                                <th>Added to Students' accounts <small>(Within selected interval)</small></th>
                                                <th>Total Arrears (Overall)</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($branches as $branch)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('dashboard.student_fee.transaction.all', ['branch_id' => $branch->id, 'date_from' => $date_from->format('d-m-Y'), 'date_to' => $date_to->format('d-m-Y'), 'expand_stats' => 1]) }}">
                                                            {{ $branch->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $branch->debit }}</td>
                                                    <td>{{ $branch->credit }}</td>
                                                    <td>{{ $branch->arrear }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif($statistics['show_class_stats'] === true)
                                    <table class="table table-bordered table-striped dtable">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Students Paid <small>(Within selected interval)</small></th>
                                                <th>Added to Students' accounts <small>(Within selected interval)</small></th>
                                                <th>Total Arrears (Overall)</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($classes as $class)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('dashboard.student_fee.transaction.all', ['branch_id' => ($branch_id ?? ''), 'current_class_id' => $class->id, 'date_from' => $date_from->format('d-m-Y'), 'date_to' => $date_to->format('d-m-Y'), 'expand_stats' => 1]) }}">
                                                            {{ $class->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $class->debit }}</td>
                                                    <td>{{ $class->credit }}</td>
                                                    <td>{{ $class->arrear }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif($statistics['show_section_stats'] === true)
                                    <table class="table table-bordered table-striped dtable">
                                        <thead>
                                            <tr>
                                                <th>Section</th>
                                                <th>Students Paid <small>(Within selected interval)</small></th>
                                                <th>Added to Students' accounts <small>(Within selected interval)</small></th>
                                                <th>Total Arrears (Overall)</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($sections as $section)
                                                <tr>
                                                    <td>
                                                        <a class="hidden-print" href="{{ route('dashboard.student_fee.transaction.all', ['branch_id' => ($branch_id ?? ''), 'current_class_id' => ($class_id ?? ''), 'section_id' => $section->id, 'date_from' => $date_from->format('d-m-Y'), 'date_to' => $date_to->format('d-m-Y'), 'expand_stats' => 1]) }}">
                                                            {{ $section->name }}
                                                        </a>
                                                        <span class="visible-print">
                                                            {{ $section->name }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $section->debit }}</td>
                                                    <td>{{ $section->credit }}</td>
                                                    <td>{{ $section->arrear }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </article>
        @endif

        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                    <h2>Transactions </h2>

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
                            <table class="table table-bordered table-striped dtable">
                                <thead>
                                    <tr>
                                        <th colspan="7" class="text-center">Totals</th>
                                        <th>{{ $totals['credit'] }}</th>
                                        <th>{{ $totals['debit'] }}</th>
                                        <th>{{ $totals['total_fee_arrears'] }}</th>
                                        <th></th>
                                    </tr>

                                    <tr>
                                        <th>PIN</th>
                                        <th>Datetime</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Transaction Description</th>
                                        <th>Added Arrears</th>
                                        <th>Paid by Students</th>
                                        <th>Overall Arrears</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentFeeTransactions as $studentFeeTransaction)
                                        <tr>
                                            <td>{{ $studentFeeTransaction->student->pin }}</td>
                                            <td class="vertical_align_middle">
                                                @if( Auth::user()->userHasPrivilege('student_fee_transaction_view_single') )
                                                    <a class="no_url_render" href="{{ route('dashboard.student_fee.transaction', ['studentFeeTransaction' => $studentFeeTransaction->id]) }}" title="Transaction detail page" rel="tooltip">
                                                        {{ $studentFeeTransaction->created_at->toDayDateTimeString() }}
                                                    </a>
                                                @else
                                                    {{ $studentFeeTransaction->created_at->toDayDateTimeString() }}
                                                @endif
                                            </td>
                                            <td class="vertical_align_middle">
                                                @if( Auth::user()->userHasPrivilege('receive_fee') )
                                                    <a class="no_url_render" href="{{ route('dashboard.student_fee.receive_fee', ['student' => $studentFeeTransaction->student_id]) }}" title="Student's fee receive page" rel="tooltip">
                                                        {{ $studentFeeTransaction->student->name }}
                                                    </a>
                                                @else
                                                    {{ $studentFeeTransaction->student->name }}
                                                @endif
                                            </td>
                                            <td class="vertical_align_middle">{{ $studentFeeTransaction->student->branch->name ?? '' }}</td>
                                            <td class="vertical_align_middle">{{ $studentFeeTransaction->student->currentClass->name ?? '' }}</td>
                                            <td class="vertical_align_middle">{{ $studentFeeTransaction->student->section->name ?? '' }}</td>
                                            <td>{{ $studentFeeTransaction->description ?? '' }}</td>
                                            <td>{{ $studentFeeTransaction->records->sum('credit') }}</td>
                                            <td>{{ $studentFeeTransaction->records->sum('debit') }}</td>
                                            <td>{{ $studentFeeTransaction->student->total_fee_arrears }}</td>
                                            <td class="vertical_align_middle text-center">
                                                @if( Auth::user()->userHasPrivilege('student_fee_transaction_delete'))
                                                    <a href="{{ route('dashboard.student_fee.transaction.delete', ['studentFeeTransaction' => $studentFeeTransaction->id]) }}"
                                                            class="btn btn-danger btn-xs delete-confirm-model no_url_render" title="Delete this transaction" rel="tooltip">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Totals</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ $totals['credit'] }}</th>
                                        <th>{{ $totals['debit'] }}</th>
                                        <th>{{ $totals['total_fee_arrears'] }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection