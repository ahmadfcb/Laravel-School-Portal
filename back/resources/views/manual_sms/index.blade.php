@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-comment"></i>
    {{ $title }}
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-comment"></i> </span>
                    <h2>Selected Students </h2>

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
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>PIN</th>
                                        <th>Name</th>
                                        <th>Father's Name</th>
                                        <th>Branch</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>{{ $student->pin }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->fatherRecord->name ?? '' }}</td>
                                            <td>{{ $student->branch->name ?? '' }}</td>
                                            <td>{{ $student->currentClass->name ?? '' }}</td>
                                            <td>{{ $student->section->name ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1">
                <header>
                    <span class="widget-icon"> <i class="fa fa-comment"></i> </span>
                    <h2>SMS </h2>

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
                        <form action="{{ route('dashboard.sms.manual') }}" method="post">
                            {{ csrf_field() }}

                            {{--Student IDs--}}
                            @foreach($students as $student)
                                <input type="hidden" name="student_ids[{{ $loop->index }}]" value="{{ $student->id }}">
                            @endforeach

                            <fieldset>
                                <div class="form-group">
                                    <label>SMS Content</label>
                                    <textarea class="form-control" id="sms_content" name="sms_content" rows="5" required>{{ old('sms_content') }}</textarea>
                                </div>
                            </fieldset>

                            <div>
                                <p class="show_hide_on_click"
                                        data-target="#available_sms_templates"
                                        data-hide-text="-"
                                        data-show-text="+"
                                        data-text-selector="#available_sms_templates_symbol">
                                    <span title="Show/Hide templates" rel="tooltip">SMS Templates</span>
                                    <span id="available_sms_templates_symbol">+</span>
                                </p>

                                <div id="available_sms_templates" style="display: none;">
                                    @foreach($smsTemplates as $smsTemplate)
                                        <p class="text-center" title="{{ str_replace('"', '\"', $smsTemplate->template) }}" rel="tooltip">
                                            <a class="sms_template_selector" href="#" data-template="{{ str_replace('"', '\"', $smsTemplate->template) }}">{{ $smsTemplate->name ?? '' }}</a>
                                        </p>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <p>Instructions</p>
                                <p>Adding any of following special texts (of the format <code>{text}</code>) in the field above will be replaced with their corresponding values (if available):</p>
                                <p>
                                    <code>{std_pin}</code> = Replaced by student's PIN.
                                    <br>
                                    <code>{std_name}</code> = Replaced by student's name.
                                    <br>
                                    <code>{father_name}</code> = Student's father name.
                                    <br>
                                    <code>{son_or_daughter}</code> = Results in either 'son' or 'daughter' based on student's gender.
                                    <br>
                                    <code>{std_branch}</code> = Branch of student.
                                    <br>
                                    <code>{std_class}</code> = Class of student.
                                    <br>
                                    <code>{std_section}</code> = Section of student.
                                    <br>
                                    <code>{institute_name}</code> = Name of institute.
                                </p>
                                <p>Example:<br><code>{std_name}</code> <code>{son_or_daughter}</code> of <code>{father_name}</code> is absent from school today.</p>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </article>

    </div>
@endsection

@push('body')
    <script type="text/javascript">
        jQuery( function ( $ ) {
            $( ".sms_template_selector" ).click( function ( e ) {
                e.preventDefault();

                var template = $( this ).data( 'template' );
                $( '#sms_content' ).val( template );
            } );
        } );
    </script>
@endpush
