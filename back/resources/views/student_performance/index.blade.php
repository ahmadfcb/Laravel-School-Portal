@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Performance</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-fighter-jet"></i>
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
                    <span class="widget-icon"> <i class="fa fa-fighter-jet"></i> </span>
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
                                    <div class="col-sm-3">
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

                                    <div class="col-sm-3">
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

                                    <div class="col-sm-3">
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
                                            <label>Performance Date</label>
                                            <input type="text" class="form-control datepicker" name="date" value="{{ old('date') ?? $date ?? '' }}" placeholder="Performance Date" data-maxdate="+0d">
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


        @if(!empty($students))

            @if($performanceExists)
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <p>Performance for {{ $date }} has already been saved!</p>

                    @if($student_performance_edit_privilege === false)
                        <p class="text-danger">You don't have privilege to update this performance.</p>
                    @endif
                </div>
            @endif

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-user"></i> </span>
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
                            <form action="{{ route('dashboard.student_performance') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="date" value="{{ $date }}">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>PIN</th>
                                                <th>Reg#</th>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                <th>Father's Name</th>
                                                <th>Performance</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($students as $student)
                                                <tr>
                                                    <td>{{ $student->pin }}</td>
                                                    <td>{{ $student->reg_no }}</td>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $student->name }}</td>
                                                    <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                                    <td>
                                                        <input type="hidden" name="students[{{ $loop->index }}][student_id]" value="{{ $student->id }}">

                                                        @foreach($performance_types as $performance_type)
                                                            <input type="hidden" name="students[{{ $loop->parent->index }}][performance][{{ $loop->index }}][performance_type_id]" value="{{ $performance_type->id }}">

                                                            <div style="text-decoration: underline;">{{ $performance_type->name }}</div>

                                                            <div class="radio">
                                                                @foreach($performance_scales as $performance_scale)
                                                                    <label class="radio-inline">
                                                                        {{-- if some performance is found for a student for a date it will be checked by default --}}
                                                                        {{-- otherwise if performance of selected date is not marked, default will be selected --}}
                                                                        {{-- if student doesn't have performance and none is selected, nothing will be selected by default --}}
                                                                        <input type="radio" name="students[{{ $loop->parent->parent->index }}][performance][{{ $loop->parent->index }}][performance_scale_id]" value="{{ $performance_scale->id }}" {{ ( $student->performances->where('student_id', '=', $student->id)->where('performance_date', '=', Carbon\Carbon::parse($date))->where('performance_type_id', '=', $performance_type->id)->contains('performance_scale_id', '=', $performance_scale->id) ? "checked" : ( $performanceExists == false && $performance_scale->id == $default_performance_scale_id ? 'checked' : '' ) ) }} {{ $performanceExists === true && $student_performance_edit_privilege === false ? 'disabled="disabled"' : '' }}> {{ $performance_scale->title }}
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="form-actions">
                                    @if ($performanceExists)
                                        @if($student_performance_edit_privilege === true)
                                            <button type="submit" class="btn btn-primary">Save Performance</button>
                                        @else
                                            <button type="button" class="btn btn-primary" disabled>You cannot edit Performance</button>
                                        @endif
                                    @else
                                        <button type="submit" class="btn btn-primary">Save Performance</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @endif

    </div>
@endsection