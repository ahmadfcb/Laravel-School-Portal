@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>SMS</li>
    <li>Templates</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-comment"></i>
    SMS Templates
@endsection

@include("layouts.partials.datatable")

@section("content")
    <div class="row">
        @if(Auth::user()->userHasPrivilege('sms_template_add'))
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
                        <span class="widget-icon"> <i class="fa fa-comment"></i> </span>
                        <h2>Add New SMS Template </h2>

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

                            <form action="{{ route('dashboard.sms.templates', ['smsTemplateEdit' => $smsTemplateEdit->id]) }}" method="post">
                                {{ csrf_field() }}

                                <fieldset>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $smsTemplateEdit->name ?? '') }}" placeholder="Name of template">
                                    </div>

                                    <div class="form-group">
                                        <label>SMS Template</label>
                                        <textarea class="form-control" name="template" placeholder="Template" rows="5" required>{{ old('template', $smsTemplateEdit->template ?? '') }}</textarea>
                                    </div>

                                    <p>Adding any of following special texts (of the format <code>{text}</code>) in the field above will be replaced with their corresponding values (if available):</p>
                                    <p>
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
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $smsTemplateEdit->id !== null ? "Update" : "Create" }}
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
                    <span class="widget-icon"> <i class="fa fa-comment"></i> </span>
                    <h2>SMS Templates </h2>

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
                                        <th>Template Name</th>
                                        <th>SMS Template</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($smsTemplates as $smsTemplate)
                                        <tr>
                                            <td>{{ $smsTemplate->name ?? '' }}</td>
                                            <td>{{ $smsTemplate->template }}</td>
                                            <td>
                                                @if(Auth::user()->userHasPrivilege('sms_template_edit'))
                                                    <a class="btn btn-default btn-xs" href="{{ route('dashboard.sms.templates', ['smsTemplateEdit' => $smsTemplate->id]) }}" rel="tooltip" title="Edit SMS Template">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                @endif

                                                @if(Auth::user()->userHasPrivilege('sms_template_add'))
                                                    <a class="btn btn-danger btn-xs confirm-action-model" href="{{ route('dashboard.sms.templates.delete', ['smsTemplate' => $smsTemplate->id]) }}"
                                                            rel="tooltip" title="Delete SMS Template"
                                                            data-body="Do you really want to delete this SMS template?">
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
