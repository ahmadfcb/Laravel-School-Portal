<?php $this->load->view("admin_dashboard/templates/admin_panel_header") ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors('<div class="alert alert-danger">', '</div>');
?>

<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        <form method="post" action="<?= site_url('admin-dashboard/reg-card-get') ?>">

            <div class="form-group">
                <label>Registration Number</label>
                <input type="text" name="reg_number[]" class="form-control form" placeholder="Registration number of the student" autofocus="" value="">
            </div>

            <div class="col-xs-12 text-center">
                <!-- Button -->
                <button style="width: 60%;" type="submit" id="submit" name="submit" class="form contact-form-button light-form-button oswald light">GET REGISTRATION CARD</button>
            </div>
        </form>
    </div>
</div>


<?php $this->load->view("admin_dashboard/templates/admin_panel_footer") ?>