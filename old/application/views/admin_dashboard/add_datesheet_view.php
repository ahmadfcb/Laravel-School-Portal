<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>




<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        
        <form action="<?= site_url('admin-dashboard/add-datesheet-process') ?>" method="POST">
            
            <div class="form-group">
                <label>Datesheet PDF file</label>
                <input type="file" name="file" required="">
            </div>
            
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Upload Datesheet</button>
            </div>
            
        </form>
        
    </div>
</div>




<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>