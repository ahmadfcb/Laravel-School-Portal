@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Attendance Types</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-table"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        @if(Auth::user()->userHasPrivilege('attendance_type_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Add Attendance Types </h2>

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
                            <form action="{{ route('dashboard.attendance_type') }}" method="post">
                                {{ csrf_field() }}

                                @if(!empty($editItem->id))
                                    {{ method_field('put') }}
                                    {{--Student attendance type ID--}}
                                    <input type="hidden" name="id" value="{{ $editItem->id }}">
                                @endif

                                <fieldset>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', ($editItem->name ?? '')) }}" placeholder="Name">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        @if(empty($editItem->id))
                                            Add
                                        @else
                                            Update
                                        @endif
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        @endif

        @if(Auth::user()->userHasPrivilege('attendance_type_add'))
            <article class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Available Attendance Types </h2>

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
                                            <th>Name</th>

                                            @if(Auth::user()->userHasPrivilege(['attendance_type_update', 'attendance_type_delete'], false))
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($student_attendance_types as $student_attendance_type)
                                            <tr>
                                                <td>{{ $student_attendance_type->name }}</td>

                                                @if(Auth::user()->userHasPrivilege(['attendance_type_update', 'attendance_type_delete'], false))
                                                    <td>
                                                        @if(Auth::user()->userHasPrivilege('attendance_type_update'))
                                                            <a href="{{ route('dashboard.attendance_type', ['editItem' => $student_attendance_type->id]) }}" class="btn btn-default btn-xs" rel="tooltip" title="Edit Attendance Type">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        @endif

                                                        @if(Auth::user()->userHasPrivilege('attendance_type_delete'))
                                                            <a href="{{ route('dashboard.attendance_type.delete', ['studentAttendanceType' => $student_attendance_type->id]) }}"
                                                                    class="btn btn-danger btn-xs confirm-action-model"
                                                                    rel="tooltip" title="Delete Attendance Type"
                                                                    data-body="Do you really want to delete this attendance type?<br>Deleting this will remove all the attendance records regarding this attendance type.<br>If you delete 'Present' attendance type, all the presents of the students will be removed.<br>Proceed with caution.">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @endif
    </div>

@endsection