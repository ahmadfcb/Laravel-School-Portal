<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        <form action="#" method="post" id="cust_form">
            
            <label>Std Reg#</label>
            <div class="input-group">
                <input type="text" id="reg_no" name="reg_no" class="form-control" placeholder="Registration number of the student">
                <span class="input-group-btn">
                    <button class="btn btn-default" id="getInfo" type="button">Get info</button>
                </span>
            </div>
            <p class="help-block">Click on Get info to fetch information of the student with registration number.</p>

            <div class="form-group">
                <label>Comments</label>
                <textarea class="form-control" name="comments" rows="3" placeholder="Something you want to keep in record about the withdrawal."></textarea>
            </div>

            <div class="ajax_result">

            </div>

            <button type="button" class="btn btn-primary cust_form_btn" data-url="<?= site_url( 'admin-dashboard/withdraw-process' ) ?>" data-target="#cust_form">Withdraw</button>
            <button type="button" class="btn btn-primary cust_form_btn" data-url="<?= site_url( 'admin-dashboard/readmit-process' ) ?>" data-target="#cust_form">Re-admin</button>
        </form>
    </div>
</div>


<script type="text/javascript">
    jQuery( function ( $ ) {
        function populate_ajax_result() {
            var std_reg = $( '#reg_no' ).val(),
                    ajax_result = $( '.ajax_result' );
            
            ajax_result.html('<p class="text-center text-bold">Loading...</p>');

            if ( std_reg != '' ) {
                $.post( '<?= site_url( "data/student-info" ) ?>', { reg_no: std_reg }, function ( res ) {

                    if ( res.has_error == true ) {
                        ajax_result.html( '<div class="alert alert-danger">' + res.msg + '</div>' );
                    } else {

                        var html = '<div class="table-responsive"><h4>Student Details</h4><table class="table">';
                        html += '<thead><tr>';
                        html += "<th>Name</th><th>Father's name</th><th>Class</th><th>Active/Withdrawn</th>";
                        html += '</tr></thead>';
                        html += '<thead><tr>';
                        html += '<td>' + res.data.first_name + ' ' + res.data.last_name + '</td><td>' + res.data.father_name + '</td><td>' + res.data.current_class + '</td><td>' + ( res.data.student_status == 'inactive' ? "Withdrawn" : "Active" ) + '</td>';
                        html += '</tr></thead>';
                        html += '</table></div>';

                        ajax_result.html( html );

                    }

                } );
            } else {
                ajax_result.html( '' );
            }

        }

        $( '#getInfo' ).on( 'click', function ( e ) {
            populate_ajax_result();
        } );
    } );
</script>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>