@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Branches</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-pagelines"></i>
    Branches
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        @if(Auth::user()->userHasPrivilege('branch_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">
                    <!-- widget options:
                        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                        data-widget-colorbutton="false"
                        data-widget-editbutton="false"
                        data-widget-togglebutton="false"
                        data-widget-deletebutton="false"
                        data-widget-fullscreenbutton="false"
                        data-widget-custombutton="false"
                        data-widget-collapsed="true"
                        data-widget-sortable="false"

                    -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pagelines"></i> </span>
                        <h2>Add Branch </h2>

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

                            <form action="{{ route('dashboard.branch', ['branch' => $branchEdit->id]) }}" method="post">
                                {{ csrf_field() }}

                                <fieldset>
                                    <div class="form-group">
                                        <label>Branch Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('branch', $branchEdit->name) }}" placeholder="Branch Name">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $branchEdit->id !== null ? "Update" : "Create" }}
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
                    <h2>Branches </h2>

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
                                        <th>Branch Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($branches as $branch)
                                        <tr>
                                            <td>{{ $branch->name }}</td>
                                            <td>
                                                @if(Auth::user()->userHasPrivilege('branch_edit'))
                                                    <a class="btn btn-default btn-xs" href="{{ route('dashboard.branch', ['branch' => $branch->id]) }}" rel="tooltip" title="Edit Branch">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userHasPrivilege('branch_add'))
                                                    <a class="btn btn-danger btn-xs confirm-action-model" href="{{ route('dashboard.branch.delete', ['branch' => $branch->id]) }}"
                                                            rel="tooltip" title="Delete Branch"
                                                            data-body="Do you really want to delete this branch?<br>Branch will be removed from all students and deleted. It will not delete any students.<br>Only delete any of these branches when you really need to do so.">
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
        <!-- WIDGET END -->
    </div>
@endsection
