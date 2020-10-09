<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

<div class="row">
    <form action="<?= site_url('admin-dashboard/add-teacher-process') ?>" method="post" enctype="multipart/form-data">
        <div class="col-sm-6">

            <h3>Personal information</h3>

            <div class="form-group">
                <label>Teacher's picture</label>
                <div class="text-center"><img class="image-preview" src="<?= base_url('uploads/default-profile-pic.jpg') ?>" width="150"></div>
                <input type="file" name="teacher_pic" class="show-image-preview">
            </div>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control form" placeholder="Name" autofocus="" value="<?= set_value( 'name' ) ?>">
            </div>

            <div class="form-group">
                <label>Father's name</label>
                <input type="text" name="father_name" class="form-control form" placeholder="Father's name" value="<?= set_value( 'father_name' ) ?>">
            </div>

            <div>
                <b>Gender</b>
                <br>
                <input type="radio" name="gender" value="male" <?= set_radio( 'gender', 'male', true ) ?>> Male <input type="radio" name="gender" value="female" <?= set_radio( 'gender', 'female' ) ?>> Female
            </div>

            <div class="form-group">
                <label>Date of birth</label>
                <input type="date" name="dob" class="form-control form" placeholder="Date of birth (YYYY-MM-DD i.e. 2017-07-07)" value="<?= set_value( 'dob') ?>">
            </div>

            <div class="form-group">
                <label>CNIC</label>
                <p class="help-block">CNIC should be without dashes.</p>
                <input type="text" name="cnic" class="form-control form" placeholder="CNIC" minlength="13" maxlength="13" value="<?= set_value( 'cnic' ) ?>">
            </div>

        </div>

        <div class="col-sm-6">

            <h3>Address</h3>

            <div class="form-group">
                <label>Street Address</label>
                <textarea class="form-control" name="street_address" rows="3" placeholder="Address"><?= set_value( 'street_address') ?></textarea>
                <div class="validation"></div>
            </div>

            <div class="form-group">
                <label>Colony</label>
                <input type="text" name="colony" class="form-control form" placeholder="Colony" value="<?= set_value( 'colony') ?>">
            </div>

            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" class="form-control form" placeholder="City" value="<?= set_value( 'city') ?>">
            </div>

            <div class="text-center">
                <button style="width: 60%;" type="submit" id="submit" name="submit" class="form contact-form-button light-form-button oswald light">ADD TEACHER'S INFO</button>
            </div>

        </div>
    </form>
</div>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>