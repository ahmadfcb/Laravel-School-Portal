@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>Fee Receive</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-money"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")

    <div class="row">
        <article class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">

                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                    <h2>REPORT </h2>

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
                        <form action="{{ route('dashboard.reports') }}" method="post">
                            {{ csrf_field() }}

                            <fieldset>
                                <div class="form-group">
                                    <label>Student PIN</label>
                                    <input type="text" class="form-control" name="pin" value="{{ old('pin') }}" placeholder="Student PIN">
                                    <p class="help-block">PIN of a student to see his/her report</p>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Proceed</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>

@endsection