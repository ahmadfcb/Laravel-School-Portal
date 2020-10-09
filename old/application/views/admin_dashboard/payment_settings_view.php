<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors('<div class="alert alert-danger">', '</div>');
?>


<form action="<?= site_url('admin-dashboard/payment-settings-update?redirect=' . urlencode( $current_url)) ?>" method="post">
    <div class="row">
        
        <div class="col-sm-6">
            <div class="form-group">
                <label>Fine on fee after 10th of month</label>
                <input type="text" name="fine_after_10" class="form-control form" placeholder="Fine after 10th of each montth" value="<?= set_value('fine1', $this->general_model->db_variables('fine_after_10')) ?>" autofocus="">
            </div>
        </div>
        
        <div class="col-xs-12 text-center">
            <!-- Button -->
            <button type="submit" id="submit" name="submit" class="btn btn-primary">Update Fine</button>
        </div>
        
    </div>
</form>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>