<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

    <div class="text-right">

        <?php if ( $next_student !== false ): ?>
            <a class="btn btn-default btn-sm" href="<?= site_url( 'admin-dashboard/student-update' ) . '?stdid=' . $next_student['student_registration_id'] ?>"><span class="glyphicon glyphicon-arrow-right"></span> Next</a>
        <?php endif; ?>

        <form action="<?= site_url( 'admin-dashboard/student-update' ) ?>" method="get" class="pull-right">
            <div class="input-group input-group-sm" style="max-width: 160px; margin-left: 5px; margin-right: 5px;">
                <input type="text" class="form-control" name="stdregno">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </form>

    </div>

    <form action="<?= site_url( 'admin-dashboard/student-registration-process' ) ?>" method="post" enctype="multipart/form-data" role="form" class="contactForm condensed_form">
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
                    <input type="number" name="registration_number" class="form-control form" placeholder="PIN" value="<?= set_value( 'registration_number', ( $latest_registration_number !== false ? $latest_registration_number + 1 : "" ) ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Registration Number</label>
                    <input type="text" name="registration_new" class="form-control form" placeholder="Registration number" value="<?= set_value( 'registration_new' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Date of Admission</label>
                    <input type="date" name="date_of_admission" class="form-control form" placeholder="Date of admission (YYYY-MM-DD i.e. 2017-07-07)" value="<?= set_value( 'date_of_admission' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Class of admission
                        <small class="text-red small">*</small>
                    </label>
                    <?= $this->generate_html_library->classes( 'admission_class' ) ?>
                    <!--
                    <select name="admission_class" class="form-control">
                        <option value="" <?= set_select( 'admission_class', '', TRUE ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'admission_class', 'Toddlers' ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'admission_class', 'LKG' ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'admission_class', 'UKG' ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'admission_class', '1st' ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'admission_class', '2nd' ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'admission_class', '3rd' ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'admission_class', '4th' ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'admission_class', '5th' ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'admission_class', '6th' ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'admission_class', '7th' ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'admission_class', '8th' ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'admission_class', '9th' ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'admission_class', '10th' ) ?> >10th</option>
                    </select>
                    -->
                    <!--<p class="help-block">Class of the student when got admission</p>-->
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Current Class
                        <small class="text-red small">*</small>
                    </label>
                    <?= $this->generate_html_library->classes( 'current_class' ); ?>
                    <!--
                    <select name="current_class" class="form-control">
                        <option value="" <?= set_select( 'current_class', '', TRUE ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'current_class', 'Toddlers' ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'current_class', 'LKG' ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'current_class', 'UKG' ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'current_class', '1st' ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'current_class', '2nd' ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'current_class', '3rd' ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'current_class', '4th' ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'current_class', '5th' ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'current_class', '6th' ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'current_class', '7th' ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'current_class', '8th' ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'current_class', '9th' ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'current_class', '10th' ) ?> >10th</option>
                    </select>
                    -->
                    <!--<p class="help-block">Current class of the student</p>-->
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Section</label>
                    <?= $this->generate_html_library->sections(); ?>
                    <!--
                    <select name="section" class="form-control">
                        <option value="" <?= set_select( 'section', '', TRUE ) ?> >--Select--</option>
                        <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                        <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                        <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                        <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                        <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
                    </select>
                    -->
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Branch</label>
                    <?= $this->generate_html_library->branches( 'school_branch' ); ?>
                    <!--
                    <select name="school_branch" id="branch_DropDown" class="form-control">
                        <option value="" <?= set_select( 'school_branch', '', TRUE ) ?> >--Select--</option>
                        <option value="KG" <?= set_select( 'school_branch', 'KG' ) ?> >KG</option>
                        <option value="Junior" <?= set_select( 'school_branch', 'Junior' ) ?> >Junior</option>
                        <option value="Girls High" <?= set_select( 'school_branch', 'Girls High' ) ?> >Girls High</option>
                        <option value="Boys High" <?= set_select( 'school_branch', 'Boys High' ) ?> >Boys High</option>
                    </select>
                    -->
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
                        <img class="image-preview" src="<?= base_url( 'uploads/default-profile-pic.jpg' ) ?>" style="max-width: 100%; max-height: 90px;">
                    </div>
                    <input type="file" name="std_pic" class="show-image-preview">
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>First Name
                        <small class="text-red small">*</small>
                    </label>
                    <input type="text" name="first_name" class="form-control form" placeholder="First name" autofocus="" value="<?= set_value( 'first_name' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control form" placeholder="Last name" value="<?= set_value( 'last_name' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>B-Form / CNIC number</label>
                    <input type="text" name="CNIC" class="form-control form" placeholder="B-Form / CNIC number" minlength="13" maxlength="13" value="<?= set_value( 'CNIC' ) ?>"/>
                    <!--<p class="help-block">CNIC should be without dashes.</p>-->
                </div>
            </div>

            <div style="clear: left;"></div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Date of birth</label>
                    <input type="date" name="dob" class="form-control form" placeholder="Date of birth (YYYY-MM-DD i.e. 2017-07-07)" value="<?= set_value( 'dob' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Date of birth in words</label>
                    <input type="text" name="dobw" class="form-control form" placeholder="Date of birth in words" value="<?= set_value( 'dobw' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div>
                    <b>Gender</b>
                    <br>
                    <input type="radio" name="gender" value="male" <?= set_radio( 'gender', 'male', TRUE ) ?>> Male
                    <input type="radio" name="gender" value="female" <?= set_radio( 'gender', 'female' ) ?>> Female
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-xs-12">
                <h4>Parent / Guardian information</h4>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="father_guardian_name" class="form-control form" placeholder="Father/Guardian name" value="<?= set_value( 'father_guardian_name' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>CNIC</label>
                    <input type="text" name="father_guardian_CNIC" class="form-control form" placeholder="Father/Guardian CNIC" minlength="13" maxlength="13" value="<?= set_value( 'father_guardian_CNIC' ) ?>"/>
                    <!--<p class="help-block">Father / Guardian CNIC. (CNIC should be without dashes.)</p>-->
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Profession</label>
                    <input type="text" name="father_guardian_profession" class="form-control form" placeholder="Father/Guardian profession" value="<?= set_value( 'father_guardian_profession' ) ?>"/>
                    <!--<p class="help-block">Profession of Father / Guardian</p>-->
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Mobile number</label>
                    <input type="text" name="father_guardian_mobile" class="form-control form" placeholder="Father/Guardian mobile i.e. 03001234567" value="<?= set_value( 'father_guardian_mobile' ) ?>"/>
                    <!--<p class="help-block">Father / Guardian Mobile number</p>-->
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

            <div class="col-xs-12 col-sm-6">
                <div class="form-group">
                    <label>Street Address</label>
                    <textarea class="form-control" name="street_address" rows="1" placeholder="Address"><?= set_value( 'street_address' ) ?></textarea>
                    <div class="validation"></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Colony</label>
                    <input type="text" name="colony" class="form-control form" placeholder="Colony" value="<?= set_value( 'colony' ) ?>"/>
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control form" placeholder="City" value="<?= set_value( 'city' ) ?>"/>
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
                    <input type="text" name="monthly_fee" class="form-control form" placeholder="Fee that student has to pay every month" value="<?= set_value( 'monthly_fee', 0 ) ?>">
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Arears (if any)
                        <small class="text-red small">*</small>
                    </label>
                    <input type="text" name="arears" class="form-control form" placeholder="Any arears available if any" value="<?= set_value( 'arears', '0' ) ?>">
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Exam Fee arears (if any)
                        <small class="text-red small">*</small>
                    </label>
                    <input type="text" name="exam_fee" class="form-control form" placeholder="Any remaining exam fee" value="<?= set_value( 'exam_fee', $this->general_model->db_variables( 'exam_fee' ) ) ?>">
                    <!--<p class="help-block">Is there any arears for exam fee? Type them here.</p>-->
                </div>
            </div>

            <div class="col-xs-12 col-sm-3">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="student_status">
                        <option value="active" <?= set_select( 'student_status', 'active', TRUE ) ?> >Active</option>
                        <option value="inactive" <?= set_select( 'student_status', 'inactive' ) ?> >Inactive</option>
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
        <a href="<?= site_url( 'admin-dashboard/students' ) ?>"><span class="glyphicon glyphicon-arrow-left"></span> Registered Students</a>
    </div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>