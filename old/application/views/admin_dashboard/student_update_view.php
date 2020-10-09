<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

    <div class="text-right">

        <?php if ( $previous_student !== false ): ?>
            <a class="btn btn-default btn-sm" href="<?= current_url() . '?stdid=' . $previous_student['student_registration_id'] . '&redirect_url=' . urlencode( $redirect_url ) ?>"><span class="glyphicon glyphicon-arrow-left"></span> Previous</a>
        <?php endif; ?>

        <button type="button" class="btn btn-default btn-sm student_details_update_edit_btn">
            <span class="glyphicon glyphicon-pencil"></span> Edit
        </button>

        <button type="button" class="btn btn-success btn-sm student_details_update_sve_btn" style="display: none;" onclick="$('#std_details_form').submit()">
            <span class="glyphicon glyphicon-check"></span> Save
        </button>

        <?php if ( $next_student !== false ): ?>
            <a class="btn btn-default btn-sm" href="<?= current_url() . '?stdid=' . $next_student['student_registration_id'] . '&redirect_url=' . urlencode( $redirect_url ) ?>"><span class="glyphicon glyphicon-arrow-right"></span> Next</a>
        <?php endif; ?>

        <form action="<?= current_url() ?>" method="get" class="pull-right">
            <div class="input-group input-group-sm" style="max-width: 160px; margin-left: 5px; margin-right: 5px;">
                <input type="text" class="form-control" name="stdregno" value="<?= (!empty($std_reg_no) ? $std_reg_no : '') ?>">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </form>

    </div>

<?php if ( empty( $student_details ) ): ?>
    <div class="alert alert-danger text-center" style="margin: 10px 0;">Student wan't found!</div>
<?php endif; ?>

    <form action="<?= site_url( 'admin-dashboard/student-update-process?stdid=' . $student_details['student_registration_id'] ) ?>" method="post" enctype="multipart/form-data" role="form" class="contactForm condensed_form" id="std_details_form">


        <div class="row">
            <div class="col-xs-12 help-block small">Fields with
                <small class="text-red">*</small>
                are essential
            </div>

            <div class="col-xs-12">
                <h4>Admission information</h4>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>PIN
                        <small class="text-red small">*</small>
                    </label>
                    <input type="number" name="registration_number" class="form-control form" placeholder="PIN number" value="<?= set_value( 'registration_number', $student_details['registration_number'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Registration Number</label>
                    <input type="text" name="registration_new" class="form-control form" placeholder="Registration number" value="<?= set_value( 'registration_new', $student_details['registration_new'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Date of Admission</label>
                    <input type="date" name="date_of_admission" class="form-control form" placeholder="Date of admission (YYYY-MM-DD i.e. 2017-07-07)" value="<?= set_value( 'date_of_admission', $student_details['admission_date'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Class of admission
                        <small class="text-red small">*</small>
                    </label>
                    <select name="admission_class" class="form-control">
                        <option value="" <?= set_select( 'admission_class', '', ( $student_details['admission_class'] == '' ) ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'admission_class', 'Toddlers', ( $student_details['admission_class'] == 'Toddlers' ) ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'admission_class', 'LKG', ( $student_details['admission_class'] == 'LKG' ) ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'admission_class', 'UKG', ( $student_details['admission_class'] == 'UKG' ) ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'admission_class', '1st', ( $student_details['admission_class'] == '1st' ) ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'admission_class', '2nd', ( $student_details['admission_class'] == '2nd' ) ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'admission_class', '3rd', ( $student_details['admission_class'] == '3rd' ) ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'admission_class', '4th', ( $student_details['admission_class'] == '4th' ) ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'admission_class', '5th', ( $student_details['admission_class'] == '5th' ) ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'admission_class', '6th', ( $student_details['admission_class'] == '6th' ) ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'admission_class', '7th', ( $student_details['admission_class'] == '7th' ) ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'admission_class', '8th', ( $student_details['admission_class'] == '8th' ) ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'admission_class', '9th', ( $student_details['admission_class'] == '9th' ) ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'admission_class', '10th', ( $student_details['admission_class'] == '10th' ) ) ?> >10th</option>
                    </select>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Current Class
                        <small class="text-red small">*</small>
                    </label>
                    <select name="current_class" class="form-control">
                        <option value="" <?= set_select( 'current_class', '', ( $student_details['current_class'] == '' ) ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'current_class', 'Toddlers', ( $student_details['current_class'] == 'Toddlers' ) ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'current_class', 'LKG', ( $student_details['current_class'] == 'LKG' ) ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'current_class', 'UKG', ( $student_details['current_class'] == 'UKG' ) ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'current_class', '1st', ( $student_details['current_class'] == '1st' ) ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'current_class', '2nd', ( $student_details['current_class'] == '2nd' ) ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'current_class', '3rd', ( $student_details['current_class'] == '3rd' ) ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'current_class', '4th', ( $student_details['current_class'] == '4th' ) ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'current_class', '5th', ( $student_details['current_class'] == '5th' ) ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'current_class', '6th', ( $student_details['current_class'] == '6th' ) ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'current_class', '7th', ( $student_details['current_class'] == '7th' ) ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'current_class', '8th', ( $student_details['current_class'] == '8th' ) ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'current_class', '9th', ( $student_details['current_class'] == '9th' ) ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'current_class', '10th', ( $student_details['current_class'] == '10th' ) ) ?> >10th</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Section</label>
                    <select name="section" class="form-control">
                        <option value="" <?= set_select( 'section', '', ( $student_details['section'] == '' ) ) ?> >--Select--</option>
                        <option value="A" <?= set_select( 'section', 'A', ( $student_details['section'] == 'A' ) ) ?> >A</option>
                        <option value="B" <?= set_select( 'section', 'B', ( $student_details['section'] == 'B' ) ) ?> >B</option>
                        <option value="C" <?= set_select( 'section', 'C', ( $student_details['section'] == 'C' ) ) ?> >C</option>
                        <option value="D" <?= set_select( 'section', 'D', ( $student_details['section'] == 'D' ) ) ?> >D</option>
                        <option value="E" <?= set_select( 'section', 'E', ( $student_details['section'] == 'E' ) ) ?> >E</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Branch</label>

                    <select name="school_branch" id="branch_DropDown" class="form-control">
                        <option value="" <?= set_select( 'school_branch', '', ( $student_details['school_branch'] == '' ) ) ?> >--Select--</option>
                        <option value="KG" <?= set_select( 'school_branch', 'KG', ( $student_details['school_branch'] == 'KG' ) ) ?> >KG</option>
                        <option value="Junior" <?= set_select( 'school_branch', 'Junior', ( $student_details['school_branch'] == 'Junior' ) ) ?> >Junior</option>
                        <option value="Girls High" <?= set_select( 'school_branch', 'Girls High', ( $student_details['school_branch'] == 'Girls High' ) ) ?> >Girls High</option>
                        <option value="Boys High" <?= set_select( 'school_branch', 'Boys High', ( $student_details['school_branch'] == 'Boys High' ) ) ?> >Boys High</option>
                    </select>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12">
                <h4>Personal Information</h4>
            </div>

            <div class="col-xs-12 col-sm-3 text-center pull-right">
                <div class="form-group">
                    <label>Student picture</label>
                    <div class="text-center">
                        <img class="image-preview" src="<?= base_url( $student_details['profile_pic'] ) ?>" style="max-width: 100%; max-height: 90px;">
                    </div>
                    <input type="file" name="std_pic" class="show-image-preview">
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>First Name
                        <small class="text-red small">*</small>
                    </label>
                    <input type="text" name="first_name" class="form-control form" placeholder="First name" autofocus="" value="<?= set_value( 'first_name', $student_details['first_name'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control form" placeholder="Last name" value="<?= set_value( 'last_name', $student_details['last_name'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>B-Form / CNIC number</label>
                    <input type="text" name="CNIC" class="form-control form" placeholder="B-Form / CNIC number" minlength="13" maxlength="13" value="<?= set_value( 'CNIC', $student_details['cnic'] ) ?>"/>
                </div>
            </div>

            <div style="clear: left;"></div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Date of birth</label>
                    <input type="date" name="dob" class="form-control form" placeholder="Date of birth (YYYY-MM-DD i.e. 2017-07-07)" value="<?= set_value( 'dob', $student_details['dob'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Date of birth in words</label>
                    <input type="text" name="dobw" class="form-control form" placeholder="Date of birth in words" value="<?= set_value( 'dobw', $student_details['dob_word'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div>
                    <b>Gender</b>
                    <br>
                    <input type="radio" name="gender" value="male" <?= set_radio( 'gender', 'male', ( $student_details['gender'] == 'male' ) ) ?>> Male
                    <input type="radio" name="gender" value="female" <?= set_radio( 'gender', 'female', ( $student_details['gender'] == 'female' ) ) ?>> Female
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12">
                <h4>Parent / Guardian information</h4>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="father_guardian_name" class="form-control form" placeholder="Father/Guardian name" value="<?= set_value( 'father_guardian_name', $student_details['father_name'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>CNIC</label>
                    <input type="text" name="father_guardian_CNIC" class="form-control form" placeholder="Father/Guardian CNIC" minlength="13" maxlength="13" value="<?= set_value( 'father_guardian_CNIC', $student_details['father_cnic'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Profession</label>
                    <input type="text" name="father_guardian_profession" class="form-control form" placeholder="Father/Guardian profession" value="<?= set_value( 'father_guardian_profession', $student_details['father_profession'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Mobile number</label>
                    <input type="text" name="father_guardian_mobile" class="form-control form" placeholder="Father/Guardian mobile i.e. 03001234567" value="<?= set_value( 'father_guardian_mobile', $student_details['father_mobile'] ) ?>"/>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Mother's name</label>
                    <input type="text" name="mother_name" class="form-control form" placeholder="Mother's name" value="<?= set_value( 'mother_name' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Mother's CNIC</label>
                    <input type="text" name="mother_cnic" class="form-control form" placeholder="Mother's CNIC" value="<?= set_value( 'mother_cnic' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Mother's profession</label>
                    <input type="text" name="mother_profession" class="form-control form" placeholder="Mother's profession" value="<?= set_value( 'mother_profession' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Mother's phone</label>
                    <input type="text" name="mother_phone" class="form-control form" placeholder="Mother's phone number" value="<?= set_value( 'mother_phone' ) ?>"/>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Mother's qualifications</label>
                    <input type="text" name="mother_qualification" class="form-control form" placeholder="Mother's qualifications" value="<?= set_value( 'mother_qualification' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12">
                <h4>Address</h4>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Colony</label>
                    <input type="text" name="colony" class="form-control form" placeholder="Colony" value="<?= set_value( 'colony', $student_details['colony'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control form" placeholder="City" value="<?= set_value( 'city', $student_details['city'] ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>Street Address</label>
                    <textarea class="form-control" name="street_address" rows="3" placeholder="Address"><?= set_value( 'street_address', $student_details['street_address'] ) ?></textarea>
                    <div class="validation"></div>
                </div>
            </div>

            <div class="col-xs-12">
                <h4>Other information</h4>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Monthly fee
                        <small class="text-red small">*</small>
                    </label>
                    <input type="text" name="monthly_fee" class="form-control form" placeholder="Fee that student has to pay every month" value="<?= set_value( 'monthly_fee', $student_details['monthly_fee'] ) ?>">
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Arears (if any)
                        <small class="text-red small">*</small>
                    </label>
                    <input type="text" name="arears" class="form-control form" placeholder="Any arears available if any" value="<?= set_value( 'arears', $student_details['arears'] ) ?>">
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Exam Fee arears (if any remaining)
                        <small class="text-red small">*</small>
                    </label>
                    <input type="text" name="exam_fee" class="form-control form" placeholder="Any remaining exam fee" value="<?= set_value( 'exam_fee', $student_details['exam_fee_arears'] ) ?>">
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="student_status">
                        <option value="active" <?= set_select( 'student_status', 'active', ( $student_details['student_status'] == 'active' ) ) ?> >Active</option>
                        <option value="inactive" <?= set_select( 'student_status', 'inactive', ( $student_details['student_status'] == 'inactive' ) ) ?> >Inactive</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 text-center hidden-print">
                <!-- Button -->
                <button class="btn btn-default print_target" type="button" data-target=".contactForm">Print</button>
                <button class="btn btn-primary" type="submit">Save Record and Add New</button>
            </div>
        </div>
    </form>

    <div>
        <a href="<?= site_url( $redirect_url ) ?>"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
    </div>


    <script type="text/javascript">
        jQuery( function ( $ ) {
            var inputs = $( '.condensed_form input, .condensed_form textarea, .condensed_form select' );

            inputs.prop( 'disabled', true );

            $( '.student_details_update_edit_btn' ).click( function () {
                inputs.prop( 'disabled', false );

                $( this ).hide();
                $( ".student_details_update_sve_btn" ).show();
            } );
        } );
    </script>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>