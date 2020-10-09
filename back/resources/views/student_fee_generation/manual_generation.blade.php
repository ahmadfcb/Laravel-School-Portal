@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-money"></i>
    {{ $title }}
@endsection

@section("content")
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-7 col-md-6 col-lg-5">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">

                <header>
                    <span class="widget-icon"> <i class="fa fa-money"></i> </span>
                    <h2>{{ $title }} </h2>

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
                        <form action="{{ route('dashboard.student_fee.generate') }}" method="post" onsubmit="return confirm('Do you want to proceed with fee generation?')">
                            {{ csrf_field() }}
                            
                            @if(empty($students_last_fee_generation_date_time))
                                <p>Fee never generated before</p>
                            @else
                                <p>Last fee generation Time: {{ $students_last_fee_generation_date_time->toDayDateTimeString() }}</p>
                            @endif
                            
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">Generate Fee</button>
                            </div>

                            <p class="help-block">You can generate fee as many times as you want, it will be generated only for those student's whose fee hasn't been generated in current month.</p>

                            @if($allow_automatic_fee_generate == 0)
                                <p>Automatic Fee Generation has been <b>turned off</b>, which can be turned back on from
                                    <a href="{{ route('dashboard.option') }}">Options page</a>.</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection