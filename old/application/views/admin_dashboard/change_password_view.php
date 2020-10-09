<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<div class="row">
    <div class="col-sm-5">
        <form action="<?= site_url( 'admin-dashboard/change-password-process' ) ?>" method="post">
            <div class="form-group">
                <label>Old Password</label>
                <input type="password" class="form-control" name="old_password" value="" placeholder="Current password of your account" required>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="new_password" value="" placeholder="New password for your account" required>
            </div>

            <div class="form-group">
                <label>New Password Confirmation</label>
                <input type="password" class="form-control" name="new_password_confirmation" value="" placeholder="New password confirmation" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Change password</button>
            </div>
        </form>
    </div>
</div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>
