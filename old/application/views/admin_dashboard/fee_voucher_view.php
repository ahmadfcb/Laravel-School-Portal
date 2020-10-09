<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<form action="<?= site_url('admin-dashboard/fee-voucher-process') ?>" method="post">
    <div class="row">
        <div class="col-xs-12 text-note top-bottom-margin">Leave those fields empty which are not applicable</div>

        <div class="col-sm-6 col-sm-offset-1">

            <div class="form-group">
                <label>Student Registration Number</label>
                <input type="text" name="std_reg_no" class="form-control" placeholder="Registration number of student">
            </div>

            <div class="form-group">
                <label>Admission Fee</label>
                <input type="text" name="adm_fee" class="form-control" placeholder="Admission fee to charge">
            </div>

            <div class="form-group">
                <label>Examination fee</label>
                <input type="text" name="exm_fee" class="form-control" placeholder="Examination fee">
            </div>

            <div class="form-group">
                <label>Computer fee</label>
                <input type="text" name="com_fee" class="form-control" placeholder="Computer fee">
            </div>

            <div class="form-group">
                <label>Voucher validity</label>
                <p class="help-block">For how much days the voucher will be valid</p>
                <input type="number" name="vch_vldty" class="form-control" placeholder="For how much days the voucher will be valid" required="">
            </div>
            
            <div class="form-group">
                <label>Fee payment type</label>
                <select class="form-control" name="fee_payment_type">
                    <option value="full_fee" <?= set_select( 'fee_payment_type', 'full_fee', TRUE) ?> >Full due fee till now</option>
                    <option value="partial_fee" <?= set_select( 'fee_payment_type', 'partial_fee') ?> >Partial fee</option>
                </select>
            </div>
            
            <div class="form-group" id="partial_school_fee" style="display: none;">
                <label>Partial school fee</label>
                <input type="text" class="form-control" name="partial_school_fee">
            </div>

            <div class="text-center">
                <!-- Button -->
                <button style="width: 40%;" type="submit" id="submit" name="submit" class="form contact-form-button light-form-button oswald light">Generate Voucher</button>
            </div>

        </div>

    </div>
</form>

<script type="text/javascript">
    jQuery(function($){
        
        var show_hide_partial_fee = function(){
            var fee_payment_type_selected = $('select[name="fee_payment_type"]').val();
            if(fee_payment_type_selected == 'partial_fee'){
                // showing partial fee
                $("#partial_school_fee").slideDown().find('input').prop('disabled', false);
            } else {
                // hiding partial fee
                $("#partial_school_fee").slideUp().find('input').prop('disabled', true).val('');
            }
        };
        
        // execute on load
        show_hide_partial_fee();
        
        // execute on change
        $('select[name="fee_payment_type"]').change(function(){
            show_hide_partial_fee();
        });
        
    });
</script>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>