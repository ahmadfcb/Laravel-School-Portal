@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>User</li>
    <li>Privileges</li>
@endsection

@section("page_header")
    <i class="fa fa-shield"></i> Privileges
@endsection

@section("page_subtitle", "{$user->name} ({$user->email})")

@include("layouts.partials.datatable")

@section("content")
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">

                <header>
                    <span class="widget-icon"> <i class="fa fa-shield"></i> </span>
                    <h2>Privileges </h2>

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

                        <form action="{{ route('dashboard.users.privilege', ['user' => $user->id]) }}" method="post">
                            {{ csrf_field() }}

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Privilege Title</th>
                                            <th>Status
                                                <input type="checkbox" class="select_all_checkbox_js" data-target-selector=".select_checkbox_js" rel="tooltip" title="Select/Unselect all privileges">
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($privileges as $privilege)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $privilege->title }}</td>
                                                <td>
                                                    <label>
                                                        <input class="select_checkbox_js" type="checkbox" name="user_privileges[]" value="{{ $privilege->id }}" {{ ( $user_privileges->contains('id', '=', $privilege->id) ? "checked" : "" ) }}>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Update</button>
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

    </div>
@endsection
