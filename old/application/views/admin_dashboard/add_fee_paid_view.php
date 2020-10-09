<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<form action="<?= site_url( 'admin-dashboard/add-fee-paid-process' ) ?>" method="post">
    <div class="col-sm-6 col-sm-offset-1">
        
        <div class="form-group">
            <label>Challan no#</label>
            <input type="text" class="form-control" name="challan_no" value="<?= set_value( 'challan_no' ) ?>">
        </div>

        <div class="form-group">
            <label>Paid amount</label>
            <input type="text" class="form-control" name="paid_amount" value="<?= set_value( 'paid_amount' ) ?>">
        </div>

        <div class="form-group">
            <label>Payment date</label>
            <input type="date" class="form-control" name="payment_date" value="<?= set_value( 'payment_date' ) ?>">
        </div>

        <div class="text-center">
            <button style="width: 55%;" type="submit" id="submit" name="submit" class="form contact-form-button light-form-button oswald light">Add fee payment details</button>
        </div>
        
    </div>
</form>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>