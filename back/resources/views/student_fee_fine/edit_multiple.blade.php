@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Student Fee Fine</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-money"></i>
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
                    <span class="widget-icon"> <i class="fa fa-search"></i> </span>
                    <h2>{{ $title }} </h2>

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
                                    <div class="col-sm-4">
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

                                    <div class="col-sm-4">
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

                                    <div class="col-sm-4">
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
                    <span class="widget-icon"> <i class="fa fa-users"></i> </span>
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
                        <form action="{{ url()->current() }}" method="post">
                            {{ csrf_field() }}

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered dtable">
                                    <thead>
                                        <tr>
                                            <th colspan="{{ 7 + ($permissions['can_edit_extra_discount'] === true ? 1 : 0) + (count($studentFeeTypes)) }}" class="text-center">Total Students: {{ $totals['total_students'] }}, Total Male: {{ $totals['total_male'] }}, Total Female: {{ $totals['total_female'] }}</th>
                                        </tr>

                                        <tr>
                                            <th>PIN</th>
                                            <th>Name</th>
                                            <th>Father's Name</th>
                                            <th>Branch</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Picture</th>

                                            @if($permissions['can_edit_extra_discount'] === true)
                                                <th>Extra Discount</th>
                                            @endif

                                            @foreach($studentFeeTypes as $studentFeeType)
                                                <th>{{ $studentFeeType->name }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <td>{{ $student->pin }}</td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                                <td>{{ $student->branch->name ?? '' }}</td>
                                                <td>{{ $student->currentClass->name ?? '' }}</td>
                                                <td>{{ $student->section->name ?? '' }}</td>
                                                <td>
                                                    <img style="width: 100%; max-width: 100px; max-height: 100px;" src="{{ Storage::url($student->image) }}" alt="{{ $student->name }}" title="{{ $student->name }}">
                                                </td>

                                                @if($permissions['can_edit_extra_discount'] === true)
                                                    <td>
                                                        <div>
                                                            <input type="text" class="form-control student_payable_monthly_fee_input" name="students[{{ $loop->index }}][extra_discount]" value="{{ $student->extra_discount ?? 0 }}" data-monthly-fee-without-extra-discount="{{ $student->monthly_fee_without_extra_discount }}" required>
                                                            <div>Student's Payable Monthly Fee: <span class="student_payable_monthly_fee">{{ $student->payable_monthly_fee }}</span></div>
                                                        </div>
                                                    </td>
                                                @endif

                                                <input type="hidden" name="students[{{ $loop->index }}][student_id]" value="{{ $student->id }}">
                                                @foreach($student->student_fee_arrears as $student_fee_arrear)
                                                    <td>
                                                        <input type="hidden" name="students[{{ $loop->parent->index }}][fee_arrears][{{ $loop->index }}][fee_type_id]" value="{{ $student_fee_arrear['feeTypeId'] }}">
                                                        <input type="number" class="form-control" style="max-width: 150px;" name="students[{{ $loop->parent->index }}][fee_arrears][{{ $loop->index }}][arrear]" value="{{ old("students[{$loop->parent->index}][fee_arrears][{$loop->index}][arrear]") ?? ($student_fee_arrear['value'] === null ? 0 : $student_fee_arrear['value']) }}" placeholder="{{ $student_fee_arrear['feeType'] }} Arrears">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>

    </div>
@endsection

@push('body')
    <script>
        jQuery( function ( $ ) {
            var calculate_replace_payable_fee = function ( ele ) {
                ele = $( ele );

                var extra_discount = parseInt( ele.val() ),
                    monthly_fee_without_extra_discount = parseInt( ele.data( 'monthly-fee-without-extra-discount' ) ),
                    output_selector = ele.parent().find( '.student_payable_monthly_fee' ),
                    amount = 0;

                if ( !isNaN( extra_discount ) ) {
                    amount = monthly_fee_without_extra_discount - extra_discount;
                    amount = (amount < 0 ? 0 : amount);

                    output_selector.text( amount );
                }
            };

            // running on events
            $( '.student_payable_monthly_fee_input' ).on( 'change keyup', function () {
                calculate_replace_payable_fee( this );
            } );
        } );
    </script>
@endpush
