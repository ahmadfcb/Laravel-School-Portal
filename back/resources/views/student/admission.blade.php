@extends("layouts.main")

@section("breadcrumb")
    <li>Dashboard</li>
    <li>{{ $title }}</li>
@endsection

@section("page_header")
    <i class="fa fa-fw fa-user"></i>
    {{ $title }}
@endsection

{{--@include("layouts.partials.datatable")--}}

@section("content")
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-0">
                <header>
                    <span class="widget-icon"> <i class="fa fa-user"></i> </span>
                    <h2>Student Admission form </h2>

                </header>

                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                        <input class="form-control" type="text">
                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">

                        <div class="admission_form">

                            <form action="{{ route('dashboard.student.admission') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                @if( $isInUpdateMode )
                                    {{ method_field('put') }}
                                    <input type="hidden" name="id" value="{{ $studentEdit->id }}">
                                @endif

                                <fieldset>
                                    <div class="row">

                                        @if( $isInUpdateMode )
                                            <div class="col-xs-12 text-center">
                                                @if($previousStudent !== null)
                                                    <a href="{{ route('dashboard.student.admission', ['studentEdit' => $previousStudent->id]) }}" class="btn btn-default" rel="tooltip" title="Previous Student">
                                                        <i class="fa fa-chevron-left"></i>
                                                    </a>
                                                @endif

                                                <button type="submit" class="btn btn-default" rel="tooltip" title="Save current student record">Update Student</button>

                                                @if($nextStudent !== null)
                                                    <a href="{{ route('dashboard.student.admission', ['studentEdit' => $nextStudent->id]) }}" class="btn btn-default" rel="tooltip" title="Next Student">
                                                        <i class="fa fa-chevron-right"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Admission information ends -->
                                        <div class="col-xs-12">
                                            <legend>Admission Information</legend>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>PIN</label>
                                                <input type="text" class="form-control" name="pin" value="{{ ( $studentEdit->pin ?: ( old('pin') ?? $currentMaxPin ) ) }}" placeholder="PIN">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Reg No.</label>
                                                <input type="text" class="form-control" name="reg_no" value="{{ old('reg_no') ?? $studentEdit->reg_no }}" placeholder="Registration Number">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Session</label>
                                                <input type="text" class="form-control" name="session" value="{{ old('session') ?? $studentEdit->session }}" placeholder="Session">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Date of Admission</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control datepicker" name="date_of_admission" value="{{ old('date_of_admission') ?? ( $isInUpdateMode ? ( !empty($studentEdit->date_of_admission) ? $studentEdit->date_of_admission->format('d-m-Y') : "" ) : \Carbon\Carbon::now()->format('d-m-Y') ) }}" placeholder="Select a date" data-dateformat="dd-mm-yy">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Class of Admission</label>
                                                <select class="form-control class_of_admission" name="class_of_admission_id">
                                                    <option value="">-Select Class Of Admission-</option>

                                                    @foreach($classes as $class)
                                                        <option value="{{ $class->id }}" {{ ( ( old('class_of_admission_id') ?? $studentEdit->class_of_admission_id ) == $class->id ? 'selected':'' ) }}>{{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Branch</label>
                                                <select class="form-control branch" name="branch_id">
                                                    <option value="">-Select Branch-</option>

                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ ( ( old('branch_id') ?? $studentEdit->branch_id ) == $branch->id ? "selected" : "" ) }}>{{ $branch->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Current Class</label>
                                                <select class="form-control current_class school_class" id="current_class_id" name="current_class_id">
                                                    <option value="">-Select Current Class-</option>

                                                    @foreach($classes as $class)
                                                        <option value="{{ $class->id }}" {{ ( ( old('current_class_id') ?? $studentEdit->current_class_id ) == $class->id ? 'selected':'' ) }}>{{ $class->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Section</label>
                                                <select class="form-control section" name="section_id">
                                                    <option value="">-Select Section-</option>

                                                    @foreach($sections as $section)
                                                        <option value="{{ $section->id }}" {{ ( ( old('section_id') ?? $studentEdit->section_id ) == $section->id ? 'selected':'' ) }}>{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control section" id="category_id" name="category_id" rel="tooltip" title="Assigning category will also assign discount of the category to the student.">
                                                    <option value="">-Select Category-</option>

                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ ( ( old('category_id') ?? $studentEdit->category_id ?? '' ) == $category->id ? 'selected':'' ) }}>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Extra Discount</label>
                                                <input type="text" class="form-control" id="extra_discount" name="extra_discount" value="{{ old('extra_discount', $studentEdit->extra_discount) }}" placeholder="Any extra discount you want to give to student other than the discount available through categories" min="0" rel="tooltip" title="Any extra discount you want to give to student other than the discount available through categories.{{ $permissions['can_edit_extra_discount'] !== true ? ' (You do not have privilege to edit this field)' : '' }}" {{ ( $permissions['can_edit_extra_discount'] !== true ? 'disabled' : '' ) }}>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Monthly Fee</label>
                                                <input type="text" class="form-control" id="fee" name="fee" value="" placeholder="Fee" min="0" readonly rel="tooltip" title="Fee for student will be according to the selected current class and category."
                                                        {{ $isInUpdateMode ? 'data-assigned-class-fee=' . $studentEdit->assigned_class_fee : '' }}>
                                                @if($isInUpdateMode)
                                                    <p class="help-block">Class fee will remain same unless manually changed for the students to whome some fee is assigned.</p>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Admission information ends -->

                                        <!-- Personal information Starts -->
                                        <div class="col-xs-12">
                                            <legend>Personal Information</legend>
                                        </div>

                                        <div class="col-sm-3 col-sm-push-9">
                                            <div class="form-group">
                                                <img style="max-height: 100px;" id="img_preview" src="{{ Storage::url( $studentEdit->image ?: 'user_images/avatars/male.png' ) }}">
                                            </div>
                                            <div>
                                                <input class="show-image-preview" data-target="#img_preview" type="file" accept="image/*" name="image">
                                                <input type="hidden" id="student_image_capture" name="image_capture" value="">
                                            </div>
                                            <div class="text-center" style="margin-top: 10px;">
                                                <button type="button" id="capture_picture_modal" class="btn btn-primary">Capture Picture</button>
                                            </div>
                                        </div>

                                        <div class="col-sm-9 col-sm-pull-3">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>Student Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $studentEdit->name }}" placeholder="Student Name">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>CNIC/B.Form</label>
                                                        <input type="text" class="form-control" name="cnic" value="{{ old('cnic') ?? $studentEdit->cnic }}" minlength="13" maxlength="13" placeholder="CNIC">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Gender</label>
                                                        <select class="form-control" name="gender">
                                                            <option value="male" {{ ( ( old('gender') ?? $studentEdit->gender ) == 'male' ? 'selected' : '' ) }}>Male</option>
                                                            <option value="female" {{ ( ( old('gender') ?? $studentEdit->gender ) == 'female' ? 'selected' : '' ) }}>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Religion</label>
                                                        <input type="text" class="form-control" name="religion" value="{{ old('religion') ?? $studentEdit->religion }}" placeholder="Religion">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Caste</label>
                                                        <input type="text" class="form-control" name="caste" value="{{ old('caste') ?? $studentEdit->caste }}" placeholder="Caste">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label>DOB</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control datepicker" name="dob" value="{{ old('dob') ?? ( !empty($studentEdit->dob) ? $studentEdit->dob->format('d-m-Y') : '' ) }}" placeholder="Select DOB" data-dateformat="dd-mm-yy">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label>DOB in words</label>
                                                        <textarea class="form-control" name="dob_words" rows="2" placeholder="It will be generated automatically if left empty. If it's not empty, available content will be used instead." rel="tooltip" title="It will be generated automatically if left empty. If it's not empty, available content will be used instead.">{{ old('dob_words') ?? $studentEdit->dob_words }}</textarea>
                                                        <p class="help-block">It will be generated automatically if left empty. If it contains some content, that will be used instead.</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label>Blood Group</label>
                                                        <input type="text" class="form-control" name="blood_group" value="{{ old('blood_group') ?? $studentEdit->blood_group }}" placeholder="Blood Group">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Personal information Ends -->

                                        <!-- Father information Starts -->
                                        <div class="col-xs-12">
                                            <legend>Father Information</legend>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>CNIC</label>
                                                <input type="text" class="form-control father_cnic" name="father_cnic" value="{{ old('father_cnic') ?? $studentEdit->fatherRecord->cnic ?? '' }}" minlength="13" maxlength="13" placeholder="CNIC" rel="tooltip" title="If details regarding provided CNIC already exists, they'll be filled in their respective inputs.">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="father_name" value="{{ old('father_name') ?? $studentEdit->fatherRecord->name ?? '' }}" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Qualification</label>
                                                <input type="text" class="form-control" name="father_qualification" value="{{ old('father_qualification') ?? $studentEdit->fatherRecord->qualification ?? '' }}" placeholder="Qualification">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input type="text" class="form-control" name="father_mobile" value="{{ old('father_mobile') ?? $studentEdit->fatherRecord->mobile ?? '' }}" placeholder="Mobile">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>SMS Cell</label>
                                                <input type="text" class="form-control" name="father_sms_cell" value="{{ old('father_sms_cell') ?? $studentEdit->fatherRecord->sms_cell ?? "" }}" placeholder="SMS Cell">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>PTCL</label>
                                                <input type="text" class="form-control" name="father_ptcl" value="{{ old('father_ptcl') ?? $studentEdit->fatherRecord->ptcl ?? '' }}" placeholder="PTCL">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" name="father_email" value="{{ old('father_email') ?? $studentEdit->fatherRecord->email ?? '' }}" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Profession</label>
                                                <input type="text" class="form-control" name="father_profession" value="{{ old('father_profession') ?? $studentEdit->fatherRecord->profession ?? '' }}" placeholder="Profession">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Job Address</label>
                                                <textarea class="form-control" name="father_job_address" rows="2" placeholder="Father's Job Address">{{ old('father_job_address') ?? $studentEdit->fatherRecord->job_address ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <!-- Father information Ends -->

                                        <!-- Mother Information Starts -->
                                        <div class="col-xs-12">
                                            <legend>Mother Information</legend>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name') ?? $studentEdit->mother_name }}" placeholder="Mother Name">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Qualifications</label>
                                                <input type="text" class="form-control" name="mother_qualification" value="{{ old('mother_qualification') ?? $studentEdit->mother_qualification }}" placeholder="Mother Qualifications">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Profession</label>
                                                <input type="text" class="form-control" name="mother_profession" value="{{ old('mother_profession') ?? $studentEdit->mother_profession }}" placeholder="Mother Profession">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" name="mother_phone" value="{{ old('mother_phone') ?? $studentEdit->mother_phone }}" placeholder="Mother Phone">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Job Address</label>
                                                <textarea class="form-control" name="mother_job_address" rows="2" placeholder="Mother's Job Address">{{ old('mother_job_address') ?? $studentEdit->mother_job_address }}</textarea>
                                            </div>
                                        </div>
                                        <!-- Mother Information Starts -->

                                        <!-- Address Information Starts -->
                                        <div class="col-xs-12">
                                            <legend>Address Information</legend>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Home Street Address</label>
                                                <textarea class="form-control" name="home_street_address" rows="2" placeholder="Home Street Address">{{ old('home_street_address') ?? $studentEdit->home_street_address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Colony</label>
                                                <input type="text" class="form-control" name="colony" value="{{ old('colony') ?? $studentEdit->colony }}" placeholder="Colony">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city" value="{{ old('city') ?? $studentEdit->city }}" placeholder="City">
                                            </div>
                                        </div>
                                        <!-- Address Information Ends -->

                                        <!-- Other Information Starts -->
                                        <div class="col-xs-12">
                                            <legend>Other Information</legend>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>School Medium</label>
                                                <select class="form-control" name="school_medium_id">
                                                    <option value="">Select School Medium</option>

                                                    @foreach($school_mediums as $school_medium)
                                                        <option value="{{ $school_medium->id }}" {{ ( ( old('school_medium_id') ?? $studentEdit->school_medium_id ) == $school_medium->id ? 'selected' : '' ) }}>{{ $school_medium->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Speciality</label>
                                                <input type="text" class="form-control" name="speciality" value="{{ old('speciality') ?? $studentEdit->speciality }}" placeholder="Speciality">
                                            </div>
                                        </div>

                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Note</label>
                                                <textarea class="form-control" name="note" placeholder="Note" rows="2">{{ old('note') ?? $studentEdit->note }}</textarea>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label>Withdrawn</label>

                                                @if( $isInUpdateMode )
                                                    <div class="bold">{{ ($studentEdit->withdrawn == 0 ? 'Active' : 'Withdrawn') }}</div>
                                                @else
                                                    <div>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="withdrawn" value="1" {{ ( old('withdrawn') ?? $studentEdit->withdrawn ) == '1'? "checked" : "" }}> Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="withdrawn" value="0" {{ ( old('withdrawn') ?? $studentEdit->withdrawn ) == '0' || ( old('withdrawn') ?? $studentEdit->withdrawn ) == null ? "checked" : "" }}> No
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Other Information Ends -->

                                        @if($isInUpdateMode)
                                        <!-- Student attachments starts -->
                                            <div class="col-xs-12">
                                                <legend class="show_hide_on_click" data-target="#available_attachments" data-hide-text="-" data-show-text="+" data-text-selector="#available_attachments_show_hide_status">Available Student Attachments (<span id="available_attachments_show_hide_status">+</span>)
                                                </legend>
                                            </div>

                                            <div class="col-xs-12">
                                                <div id="available_attachments" class="table-responsive" style="display: none;">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr.</th>
                                                                <th>Attachment</th>
                                                                <th>Title</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach($studentEdit->attachments as $attachment)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>
                                                                        <a href="{{ Storage::url($attachment->path) }}">{{ $attachment->path }}</a>
                                                                    </td>
                                                                    <td>{{ $attachment->title }}</td>
                                                                    <td>
                                                                        <a href="{{ route('dashboard.student_attachment.delete', ['studentAttachment' => $attachment->id]) }}" class="btn btn-danger btn-xs delete-confirm-model" rel="tooltip" title="Remove this attachment">
                                                                            <i class="fa fa-trash-o"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Add student attachments starts -->
                                        <div class="col-xs-12">
                                            <legend class="show_hide_on_click" data-target="#attachments_container" data-hide-text="-" data-show-text="+" data-text-selector="#add_student_attachment_show_hide_status">Add Student Attachments (<span id="add_student_attachment_show_hide_status">+</span>)
                                            </legend>
                                        </div>

                                        <div class="col-xs-12">
                                            <div id="attachments_container" class="table-responsive" style="display: none;">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr.</th>
                                                            <th>Attachment</th>
                                                            <th>Title</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        {{--<tr>--}}
                                                        {{--<td>1</td>--}}
                                                        {{--<td>--}}
                                                        {{--<input type="file" name="attachments[][file]">--}}
                                                        {{--</td>--}}
                                                        {{--<td>--}}
                                                        {{--<input type="text" class="form-control" name="attachments[][title]">--}}
                                                        {{--</td>--}}
                                                        {{--<td>--}}
                                                        {{--<button type="button" class="btn btn-danger btn-xs remove_attachment_btn">--}}
                                                        {{--<i class="fa fa-trash-o"></i>--}}
                                                        {{--</button>--}}
                                                        {{--</td>--}}
                                                        {{--</tr>--}}
                                                    </tbody>
                                                </table>

                                                <div>
                                                    <button type="button" id="add_attachments_btn" class="btn btn-primary" rel="tooltip" title="Add more attachments">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Add student attachments ends -->

                                        <!-- Student sibling starts -->
                                        <div class="col-xs-12">
                                            <legend class="show_hide_on_click" data-target="#student_sibling" data-hide-text="-" data-show-text="+" data-text-selector="#student_sibling_show_hide_status">Student's Siblings (<span id="student_sibling_show_hide_status">+</span>)
                                            </legend>
                                        </div>

                                        <div class="col-xs-12">
                                            <div class="table-responsive" id="student_sibling" style="display: none;">
                                                <table class="table table-bordered table-striped siblings_table">
                                                    <thead>
                                                        <tr>
                                                            <th>CNIC</th>
                                                            <th>Name</th>
                                                            <th>Class</th>
                                                            <th>School</th>
                                                            <th>Note</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @if($isInUpdateMode)
                                                            @foreach($studentEdit->siblings as $sibling)
                                                                <tr>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="siblings_cnic[]" value="{{ $sibling->cnic }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="siblings_name[]" value="{{ $sibling->name }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="siblings_class[]" value="{{ $sibling->class }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control" name="siblings_school[]" value="{{ $sibling->school }}">
                                                                    </td>
                                                                    <td>
                                                                        <textarea class="form-control" name="siblings_note[]">{{ $sibling->note }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger btn-xs remove_sibling_btn">
                                                                            <i class="fa fa-trash-o"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>

                                                <div>
                                                    <button type="button" class="btn btn-primary add_sibling_btn" rel="tooltip" title="Add sibling">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Student sibling ends -->

                                        <!-- Fee Assignment starts -->
                                        {{--It will be only shown for admission page--}}
                                        @if($isInUpdateMode === false)
                                            <div class="col-xs-12">
                                                <legend>Assign fee to student's account alongwith admission</legend>
                                                <p style="font-style: italic">Automatic fee generation will add proper fee to the student's accounts on fixed times and dates, but fee from this page will be added to student's individual accounts alongwith admission.<br>If you want to receive student's monthly fee too, you only need to select the corresponding checkbox and the payable monthly fee will be added to the student's account.</p>

                                                <div class="row">
                                                    @foreach($studentFeeTypes as $studentFeeType)
                                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                                                            <input type="hidden" name="student_fee_types[{{ $loop->index }}][fee_type_id]" value="{{ $studentFeeType->id }}">
                                                            <div class="form-horizontal" style="margin-bottom: 10px;">
                                                                <label>{{ $studentFeeType->name }}: <small>{{ $studentFeeType->fee }}</small></label>
                                                                <div class="input-group">
																	<span class="input-group-addon">
																		<span class="checkbox">
																			<label>
																			  <input type="checkbox" class="checkbox style-0" name="student_fee_types[{{ $loop->index }}][selected]" value="1" {{ old("student_fee_types[{$loop->index}][selected]", 0) == '1' ? 'checked':'' }}>
																			  <span></span>
																			</label>
																		</span>
																	</span>
                                                                    {{--show only if this fee type is not the monthly fee--}}
                                                                    @if($studentFeeType->id != $student_fee_type_monthly_fee_id)
                                                                        <input class="form-control" type="text" name="student_fee_types[{{ $loop->index }}][fee_amount]" value="{{ old("student_fee_types[{$loop->index}][fee_amount]", ($studentFeeType->fee ?? 0)) }}">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="text-center">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="checkbox style-0" name="proceed_to_fee_receive" value="1">
                                                            <span>Proceed to fee receive after admission</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Fee Assignment ends -->
                                    </div>
                                </fieldset>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        @if($isInUpdateMode === false)
                                            Add Student
                                        @else
                                            Update Student
                                        @endif
                                    </button>
                                </div>
                            </form>

                        </div>

                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Capture Image</h4>
                </div>
                <div class="modal-body">

                    <div class="row text-center">
                        <div class="col-sm-12">
                            <video id="image_capture_video" autoplay style="width: 100%;"></video>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default student_image_capture_stop_tracks" data-dismiss="modal">Cancle</button>
                    <button type="button" class="btn btn-primary image_capture_btn" data-dismiss="modal">Capture Image</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@push("body")
    <script>
        jQuery( function ( $ ) {
            /* Attachment code starts */
            var attachments_container = $( "#attachments_container" );

            var sort_sr_no = function () {
                attachments_container.find( 'tbody tr' ).each( function ( i, d ) {
                    var td = $( d ).find( 'td' )[0];

                    $( td ).text( i + 1 );
                } );
            };

            $( "#add_attachments_btn" ).click( function () {
                var row = '<tr>';
                row += '<td>' + ( attachments_container.find( 'tbody tr' ).length + 1 ) + '</td>';
                row += '<td><input type="file" name="attachments[][file]"></td>';
                row += '<td><input type="text" class="form-control" name="attachments[][title]"></td>';
                row += '<td><button type="button" class="btn btn-danger btn-xs remove_attachment_btn"><i class="fa fa-trash-o"></i></button></td>';
                row += '</tr>';

                attachments_container.find( 'tbody' ).append( row );
            } );

            attachments_container.on( 'click', '.remove_attachment_btn', function () {
                if ( confirm( "Do you really want to remove this attachment?" ) ) {
                    $( this ).parents( 'tr' ).remove();
                    sort_sr_no();
                }
            } );
            /* Attachments code ends */

            /* Siblings code starts */
            $( ".add_sibling_btn" ).click( function () {
                var html = '<tr>\n' +
                    '    <td>\n' +
                    '        <input type="text" class="form-control" name="siblings_cnic[]">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <input type="text" class="form-control" name="siblings_name[]">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <input type="text" class="form-control" name="siblings_class[]">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <input type="text" class="form-control" name="siblings_school[]">\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <textarea class="form-control" name="siblings_note[]"></textarea>\n' +
                    '    </td>\n' +
                    '    <td>\n' +
                    '        <button type="button" class="btn btn-danger btn-xs remove_sibling_btn">\n' +
                    '            <i class="fa fa-trash-o"></i>\n' +
                    '        </button>\n' +
                    '    </td>\n' +
                    '</tr>';

                $( '.siblings_table tbody' ).append( html );
            } );

            $( '.siblings_table' ).on( 'click', '.remove_sibling_btn', function () {
                $( this ).parents( 'tr' ).remove();
            } );
            /* Siblings code ends */

            /* Get Fee starts */
            var get_fee = function () {
                var link = "{!! route('api.get_fee') !!}",
                    current_class_id = $( "#current_class_id" ).val(),
                    category_id = $( "#category_id" ).val(),
                    fee_input = $( "#fee" ),
                    extra_discount = $( "#extra_discount" ).val(),
                    isInUpdateMode = "{{ $isInUpdateMode == true ? 'true' : 'false' }}";

                // changing assigned string true/false to actual true/false
                isInUpdateMode = (isInUpdateMode == 'true' ? true : false);

                fee_input.val( '...' );

                // forming request data that will be sent as parameters to the url
                var requestData = {
                    category_id: category_id
                };
                // if editing, in update mode
                if ( isInUpdateMode ) {
                    requestData.current_class_id = current_class_id;

                    var assignedClassFee = fee_input.data( 'assigned-class-fee' );
                    assignedClassFee = parseInt( assignedClassFee );
                }

                $.get( link, requestData, function ( data ) {

                    var fee = data.fee;

                    // if page is in update mode
                    if ( isInUpdateMode ) {
                        // get absolute value of fee as it can be negative. Because only discount in negative form is given
                        fee = Math.abs( fee );
                        // final fee is obtained by getting subtraction discount obtained from here to the assigned fee
                        fee = assignedClassFee - fee;
                    }

                    fee -= extra_discount;
                    fee = (fee <= 0 ? 0 : fee);
                    fee_input.val( fee );

                } ).fail( function () {
                    fee_input.val( '' );
                } );
            };

            get_fee();

            $( "#current_class_id, #category_id, #extra_discount" ).on( 'change', function () {
                get_fee();
            } );
            /* Get Fee ends */

            /* Getting webcam access starts */
            function webcam_access() {
                var video = $( "#image_capture_video" )[0];

                function capture_picture_modal_click() {
                    if ( navigator.mediaDevices.getUserMedia ) {
                        navigator.mediaDevices.getUserMedia( {video: true} )
                            .then( function ( stream ) {
                                window.studentPictureVideoStream = stream;
                                video.srcObject = stream;

                                $( "#myModal" ).modal( 'show' );
                            } )
                            .catch( function ( error ) {
                                console.log( "Something went wrong!" );
                                alert( "Either you didn't allow this page to open webcam or there is no webcam available" );
                            } );
                    }
                }

                $( "#capture_picture_modal" ).click( function () {
                    capture_picture_modal_click();
                } );

                function stop_tracks() {
                    var tracks = window.studentPictureVideoStream.getTracks();
                    for ( var i = 0; i < tracks.length; i++ ) {
                        tracks[i].stop();
                    }
                }

                $(".student_image_capture_stop_tracks").click(function(){
                    stop_tracks();
                });

                var image_capture = function () {
                    var canvas = document.createElement( 'canvas' ),
                        ctx = canvas.getContext( '2d' ),
                        video_width = video.videoWidth,
                        video_height = video.videoHeight;

                    canvas.width = video_width;
                    canvas.height = video_height;

                    ctx.drawImage( video, 0, 0, video_width, video_height );

                    var image_data = canvas.toDataURL( 'image/png' );
                    $( "#img_preview" ).attr( 'src', image_data );

                    $( "#student_image_capture" ).val( image_data );

                    stop_tracks();
                };

                $( ".image_capture_btn" ).on( 'click', function () {
                    image_capture();
                } );
            }

            webcam_access();
            /* Getting webcam access ends */
        } );
    </script>
@endpush
