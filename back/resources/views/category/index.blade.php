@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Categories</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-pagelines"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        @if(Auth::user()->userHasPrivilege('category_add'))
            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-0">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-pagelines"></i> </span>
                        <h2>Add Category </h2>

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

                            <form action="{{ route('dashboard.category', ['categoryEdit' => $categoryEdit->id]) }}" method="post">
                                {{ csrf_field() }}

                                <fieldset>
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $categoryEdit->name) }}" placeholder="Category Name">
                                    </div>

                                    <div class="form-group">
                                        <label>Fee Discount</label>
                                        <input type="number" class="form-control" name="fee_discount" value="{{ old('fee_discount', $categoryEdit->fee_discount) }}" min="0" placeholder="Fee Discount">
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $categoryEdit->id !== null ? "Update" : "Create" }}
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
                    <h2>Categories </h2>

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
                                        <th>Category Name</th>
                                        <th>Fee Discount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->fee_discount }}</td>
                                            <td>
                                                @if(Auth::user()->userHasPrivilege('category_edit'))
                                                    <a class="btn btn-default btn-xs" href="{{ route('dashboard.category', ['categoryEdit' => $category->id]) }}" rel="tooltip" title="Edit Category">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userHasPrivilege('category_delete'))
                                                    <a class="btn btn-danger btn-xs confirm_action_model" href="{{ route('dashboard.category.delete', ['category' => $category->id]) }}"
                                                            rel="tooltip" title="Delete Category"
                                                            data-body="Do you really want to delete this category?<br>It will be removed from all the students and deleted.<br>It will not delete any student.">
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
