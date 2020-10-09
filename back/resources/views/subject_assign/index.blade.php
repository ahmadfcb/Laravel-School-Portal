@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Categories</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-book"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        @if(Auth::user()->userHasPrivilege('subject_assign_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-book"></i> </span>
                        <h2>Subject Assignment </h2>

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

                            <form action="{{ route('dashboard.subject_assignment') }}" method="post">
                                {{ csrf_field() }}

                                @if($editItem->id !== null)
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="branch_class_section_id" value="{{ $editItem->id }}">
                                @endif

                                <fieldset>
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select name="branch_id" class="form-control">
                                            <option value="">---Select Branch---</option>

                                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ ( ( old('branch_id') ?? $editItem->branch_id ) == $branch->id ? "selected" : "" ) }}>{{ $branch->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Class</label>

                                        <select name="class_id" class="form-control">
                                            <option value="">---Select Class---</option>

                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ ( ( old('class_id') ?? $editItem->class_id ) == $class->id ? "selected" : "" ) }}>{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Section</label>

                                        <select name="section_id" class="form-control">
                                            <option value="">---Select Section---</option>

                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}" {{ ( ( old('section_id') ?? $editItem->section_id ) == $section->id ? "selected" : "" ) }}>{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>Subjects</div>
                                    <div class="checkbox">
                                        @foreach($subjects as $subject)
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" {{ ( collect( old('subject_ids') )->contains($subject->id) || $editItem->subjects->contains($subject->id) ? "checked" : "" ) }}> {{ $subject->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Assign</button>
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

        @if(Auth::user()->userHasPrivilege('subject_assign_view'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-book"></i> </span>
                        <h2>Assigned Subjects </h2>

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
                                <table class="table table-striped table-bordered dtable">
                                    <thead>
                                        <tr>
                                            <th>Branch</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Subject</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($assignedSubjects as $assignedSubject)
                                            <tr>
                                                <td>{{ $assignedSubject->branch->name }}</td>
                                                <td>{{ $assignedSubject->schoolClass->name }}</td>
                                                <td>{{ $assignedSubject->section->name }}</td>
                                                <td>
                                                    <ol>
                                                        @foreach($assignedSubject->branchClassSectionSubjects as $branchClassSectionSubject)
                                                            <li>{{ $branchClassSectionSubject->subject->name }}</li>
                                                        @endforeach
                                                    </ol>
                                                </td>
                                                <td>
                                                    <a href="{{ route('dashboard.subject_assignment', ['editItem' => $assignedSubject->id]) }}" class="btn btn-default btn-xs" rel="tooltip" title="Edit">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
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
        @endif
    </div>
@endsection