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
        @if(Auth::user()->userHasPrivilege('performance_scale_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-fighter-jet"></i> </span>
                        <h2>Add Performance Scale </h2>

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
                            <form action="{{ route('dashboard.performance_scale') }}" method="post">
                                {{ csrf_field() }}

                                @if(!empty($editItem->id))
                                    {{ method_field('put') }}
                                    {{--Performance Scale ID--}}
                                    <input type="hidden" name="id" value="{{ $editItem->id }}">
                                @endif
                                
                                <fieldset>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" value="{{ old('title', ($editItem->title ?? '')) }}" placeholder="Title" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Scale Weight</label>
                                        <p class="help-block">i.e. For one star this should contain 1, for 2 stars this sould contain 2 etc.</p>
                                        <input type="number" class="form-control" name="scale_weight" value="{{ old('scale_weight', ( $editItem->scale_weight ?? '' ) ) }}" placeholder="Scale Weight" min="1" required>
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

        @if(Auth::user()->userHasPrivilege('performance_scale_view'))
            <article class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-fighter-jet"></i> </span>
                        <h2>Available Performance Scales </h2>

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
                                            <th>Scale Weight</th>
                                            <th>Title</th>

                                            @if(Auth::user()->userHasPrivilege(['performance_scale_edit', 'performance_scale_delete'], false))
                                                <th>Actions</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($performance_scales as $performance_scale)
                                            <tr>
                                                <td>{{ $performance_scale->scale_weight }}</td>
                                                <td>{{ $performance_scale->title }}</td>

                                                @if(Auth::user()->userHasPrivilege(['performance_scale_edit', 'performance_scale_delete'], false))
                                                    <td>
                                                        @if(Auth::user()->userHasPrivilege('performance_scale_edit'))
                                                            <a href="{{ route('dashboard.performance_scale', ['editItem' => $performance_scale->id]) }}" class="btn btn-default btn-xs" rel="tooltip" title="Edit Performance Scale">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                        @endif

                                                        @if(Auth::user()->userHasPrivilege('performance_scale_delete'))
                                                            <a href="{{ route('dashboard.performance_scale.delete', ['performanceScale' => $performance_scale->id]) }}"
                                                                    class="btn btn-danger btn-xs confirm-action-model"
                                                                    rel="tooltip" title="Delete Performance Scale"
                                                                    data-body="Do you really want to delete this performance scale?<br>Deleting any of these will remove corresponding details from reports.<br>Deleting any of these is not recommended.">
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