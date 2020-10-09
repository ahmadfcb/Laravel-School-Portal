@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Print Sheet</li>
    <li>Columns</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-bookmark"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        @if(Auth::user()->userHasPrivilege('print_sheet_columns_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-bookmark"></i> </span>
                        <h2>Add Print Sheet Column </h2>

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

                            <form action="{{ route('dashboard.print_sheet', ['printSheetColumnEdit' => $printSheetColumnEdit->id]) }}" method="post">
                                {{ csrf_field() }}

                                <fieldset>
                                    <div class="form-group">
                                        <label>Print Sheet Column Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $printSheetColumnEdit->name) }}" placeholder="Print Sheet Column Name">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $printSheetColumnEdit->id !== null ? "Update" : "Create" }}
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
                    <span class="widget-icon"> <i class="fa fa-bookmark"></i> </span>
                    <h2>Print Sheet Columns </h2>

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
                                    @foreach($printSheetColumns as $printSheetColumn)
                                        <tr>
                                            <td>{{ $printSheetColumn->name }}</td>
                                            <td>
                                                @if(Auth::user()->userHasPrivilege('print_sheet_columns_edit'))
                                                    <a class="btn btn-default btn-xs" href="{{ route('dashboard.print_sheet', ['printSheetColumnEdit' => $printSheetColumn->id]) }}" rel="tooltip" title="Edit Print Sheet">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userHasPrivilege('print_sheet_columns_delete'))
                                                    <a class="btn btn-danger btn-xs delete-confirm-model" href="{{ route('dashboard.print_sheet.delete', ['printSheetColumn' => $printSheetColumn->id]) }}" rel="tooltip" title="Delete Print Sheet Column">
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
