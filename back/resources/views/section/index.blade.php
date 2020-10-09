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
        @if(Auth::user()->userHasPrivilege('section_add'))
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-book"></i> </span>
                        <h2>Add Section </h2>

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

                            <form action="{{ route('dashboard.section') }}" method="post">
                                {{ csrf_field() }}

                                {{--if section edit ID is provided--}}
                                @if($sectionEdit->id !== null)
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="id" value="{{ $sectionEdit->id }}">
                                @endif

                                <fieldset>
                                    <div class="form-group">
                                        <label>Section</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', ($sectionEdit->name ?: "") ) }}" placeholder="Section Name">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        @if($sectionEdit->id === null)
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
                    <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                    <h2>Section </h2>

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
                                    @foreach($sections as $section)
                                        <tr>
                                            <td>{{ $section->name }}</td>
                                            <td>
                                                @if(Auth::user()->userHasPrivilege('section_edit'))
                                                    <a href="{{ route('dashboard.section', ['sectionEdit' => $section->id]) }}" class="btn btn-default btn-xs" rel="tooltip" title="Edit section">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userHasPrivilege('section_delete'))
                                                    <a href="{{ route('dashboard.section.delete', ['section' => $section->id]) }}" class="btn btn-danger btn-xs confirm_action_model"
                                                            rel="tooltip" title="Delete section"
                                                            data-body="Do you really want to delete this section?<br>It will be deleted after being removed from all the students.<br>No student will be removed">
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