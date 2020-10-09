<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

<div class="row">
    <div class="col-sm-6">
        <form action="<?= site_url('fee/receive_fee_form_process') ?>" method="post">
            <div class="form-group">
                <label>PIN</label>
                <input type="text" class="form-control" name="pin" placeholder="PIN of the student">
            </div>

            <div class="form-group">
                <button class="btn btn-default center-block" type="submit">Receive Fee</button>
            </div>
        </form>
    </div>
</div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>
