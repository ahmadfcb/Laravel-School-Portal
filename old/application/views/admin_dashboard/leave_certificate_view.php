<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

<div class="row">
    <div class="col-sm-12">
        <form method="post" action="" class="cust_form form-inline text-center" id="cust_form">

            <div class="form-group">
                <label>PIN</label>
                <input type="text" name="reg_number" class="form-control form" placeholder="PIN of the student" autofocus="" value="">
            </div>

            <div class="form-group">
                <label>Student enrollment date</label>
                <input type="date" name="from_date" class="form-control form" placeholder="Student enrollment start" autofocus="" value="">
            </div>

            <div class="form-group">
                <label>School leaving date</label>
                <input type="date" name="to_date" class="form-control form" placeholder="Student leaving date" autofocus="" value="">
            </div>

            <div class="form-group">
                <label>Conduct</label>
                <input type="text" name="conduct" class="form-control form" placeholder="Student conduct" autofocus="" value="">
            </div>

            <div class="">
                <button type="button" class="btn btn-primary cust_form_btn" data-url="<?= site_url( 'admin-dashboard/character-certificate-get' ) ?>" data-target="#cust_form">GET CHARACTER CERTIFICATE</button>
                
                <button type="button" class="btn btn-primary cust_form_btn" data-url="<?= site_url( 'admin-dashboard/leave-certificate-get' ) ?>" data-target="#cust_form">GET LEAVING CERTIFICATE</button>
            </div>
            
        </form>

    </div>
</div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>