@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-book"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")

    <div class="row">
        @if(Auth::user()->userHasPrivilege('subject_add'))
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-book"></i> </span>
                        <h2>Add subject </h2>

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

                            <form action="{{ route('dashboard.subject') }}" method="post">
                                {{ csrf_field() }}

                                {{--if subject edit ID is provided--}}
                                @if($subjectEdit->id !== null)
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="id" value="{{ $subjectEdit->id }}">
                                @endif

                                <fieldset>
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input type="text" class="form-control" name="subject" value="{{ old('subject', ($subjectEdit->name ?: "") ) }}" placeholder="Subject">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        @if($subjectEdit->id === null)
                                            Create
                                        @else
                                            Update
                                        @endif
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
        @endif

        <article class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-book"></i> </span>
                    <h2>Subjects </h2>

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
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($subjects as $subject)
                                        <tr>
                                            <td>{{ $subject->name }}</td>
                                            <td>
                                                @if(Auth::user()->userHasPrivilege('subject_edit'))
                                                    <a href="{{ route('dashboard.subject', ['subjectEdit' => $subject->id]) }}" class="btn btn-default btn-xs" rel="tooltip" title="Edit Subject">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userHasPrivilege('subject_delete'))
                                                    <a href="{{ route('dashboard.subject.delete', ['subject' => $subject->id]) }}"
                                                            class="btn btn-danger btn-xs confirm-action-model"
                                                            rel="tooltip" title="Delete Subject"
                                                            data-body="Do you really want to delete it?<br>Deleting this subject will remove it from any class and section.">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
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
    </div>

@endsection