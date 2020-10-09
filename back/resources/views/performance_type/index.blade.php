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
        @if(Auth::user()->userHasPrivilege('performance_type_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-fighter-jet"></i> </span>
                        <h2>Add Performance Types </h2>

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
                            <form action="{{ route('dashboard.performance_type') }}" method="post">
                                {{ csrf_field() }}

                                @if(!empty($editItem->id))
                                    {{ method_field('put') }}
                                    {{--Performance type ID--}}
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

        @if(Auth::user()->userHasPrivilege('performance_type_add'))
            <article class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-fighter-jet"></i> </span>
                        <h2>Available Performance Types </h2>

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

                                            @if(Auth::user()->userHasPrivilege(['performance_type_update', 'performance_type_delete'], false))
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($performanceTypes as $performanceType)
                                            <tr>
                                                <td>{{ $performanceType->name }}</td>

                                                @if(Auth::user()->userHasPrivilege(['performance_type_update', 'performance_type_delete'], false))
                                                    <td>
                                                        @if(Auth::user()->userHasPrivilege('performance_type_update'))
                                                            <a href="{{ route('dashboard.performance_type', ['editItem' => $performanceType->id]) }}" class="btn btn-default btn-xs" rel="tooltip" title="Edit Performance Type">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        @endif

                                                        @if(Auth::user()->userHasPrivilege('performance_type_delete'))
                                                            <a href="{{ route('dashboard.performance_type.delete', ['performanceType' => $performanceType->id]) }}"
                                                                    class="btn btn-danger btn-xs confirm-action-model"
                                                                    rel="tooltip" title="Delete Performance Type"
                                                                    data-body="Do you really want to delete this performance type?<br>Deleting this will remove corresponding details from reports.<br>Proceed with caution!">
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