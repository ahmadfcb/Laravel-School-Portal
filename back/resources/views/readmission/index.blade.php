@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-chain"></i>
    {{ $title }}
@endsection

{{--@include("layouts.partials.datatable")--}}

@section("content")
    <div class="row">
        <article class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-chain"></i> </span>
                    <h2>Details </h2>

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

                        @if(!empty($student->image))
                            <div class="text-center" style="margin-bottom: 10px;">
                                <img src="{{ Storage::url($student->image) }}" style="max-height: 100px; max-width: 100px;">
                            </div>
                        @endif

                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Pin</th>
                                    <td>{{ $student->pin }}</td>
                                </tr>

                                <tr>
                                    <th>Reg#</th>
                                    <td>{{ $student->reg_no }}</td>
                                </tr>

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $student->name }}</td>
                                </tr>

                                <tr>
                                    <th>Branch</th>
                                    <td>{{ $student->branch->name ?? "N/A" }}</td>
                                </tr>

                                <tr>
                                    <th>Class</th>
                                    <td>{{ $student->currentClass->name ?? "N/A" }}</td>
                                </tr>

                                <tr>
                                    <th>Section</th>
                                    <td>{{ $student->section->name ?? "N/A" }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <form action="{{ route('dashboard.readmission', ['student' => $student->id]) }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="redirect_back" value="{{ back()->getTargetUrl() }}">

                            <fieldset>
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea class="form-control" name="comment" rows="5">{{ old('comment') }}</textarea>
                                </div>
                            </fieldset>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Re-Enroll</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
@endsection