<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        <form action="<?= site_url('admin-dashboard/sms-broadcast') ?>" method="post">
            <div class="form-group">
                <label>SMS message</label>
                <textarea rows="5" name="sms" class="form-control" placeholder="SMS message that you want to send" required=""><?= set_value( 'sms' ) ?></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Send SMS to ALL</button>
        </form>
    </div>
</div>



<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>