<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

<div class="student_details">

    <div><img src="<?= base_url( $student_details[ 'profile_pic' ] ) ?>" width="150"></div>

    <div class="table-responsive">
        <table class="table table-no-border">
            <tr>
                <td><b>Name:</b> <?= (empty( $student_details[ 'first_name' ] ) ? "N/A" : $student_details[ 'first_name' ]) ?></td>
                <td><b>Last name:</b> <?= (empty( $student_details[ 'last_name' ] ) ? "N/A" : $student_details[ 'last_name' ]) ?></td>
            </tr>

            <tr>
                <td><b>Gender:</b> <?= (empty( $student_details[ 'gender' ] ) ? "N/A" : $student_details[ 'gender' ]) ?></td>
                <td><b>DOB:</b> <?= (empty( $student_details[ 'dob' ] ) ? "N/A" : $student_details[ 'dob' ]) ?></td>
            </tr>

            <tr>
                <td><b>Student CNIC:</b> <?= (empty( $student_details[ 'cnic' ] ) ? "N/A" : $student_details[ 'cnic' ]) ?></td>
                <td><b>Father's name:</b> <?= (empty( $student_details[ 'father_name' ] ) ? "N/A" : $student_details[ 'father_name' ]) ?></td>
            </tr>

            <tr>
                <td><b>Father's CNIC:</b> <?= (empty( $student_details[ 'father_cnic' ] ) ? "N/A" : $student_details[ 'father_cnic' ]) ?></td>
                <td><b>Father's Profession:</b> <?= (empty( $student_details[ 'father_profession' ] ) ? "N/A" : $student_details[ 'father_profession' ]) ?></td>
            </tr>

            <tr>
                <td><b>Father's mobile:</b> <?= (empty( $student_details[ 'father_mobile' ] ) ? "N/A" : $student_details[ 'father_mobile' ]) ?></td>
                <td><b>Admission date:</b> <?= (empty( $student_details[ 'admission_date' ] ) ? "N/A" : $student_details[ 'admission_date' ]) ?></td>
            </tr>

            <tr>
                <td><b>Registration no#</b> <?= (empty( $student_details[ 'registration_number' ] ) ? "N/A" : $student_details[ 'registration_number' ]) ?></td>
                <td><b>Admission class:</b> <?= (empty( $student_details[ 'admission_class' ] ) ? "N/A" : $student_details[ 'admission_class' ]) ?></td>
            </tr>

            <tr>
                <td><b>Current class:</b> <?= (empty( $student_details[ 'current_class' ] ) ? "N/A" : $student_details[ 'current_class' ]) ?></td>
                <td><b>Section:</b> <?= (empty( $student_details[ 'section' ] ) ? "N/A" : $student_details[ 'section' ]) ?></td>
            </tr>

            <tr>
                <td><b>School branch:</b> <?= (empty( $student_details[ 'school_branch' ] ) ? "N/A" : $student_details[ 'school_branch' ]) ?></td>
                <td><b>Street address:</b> <?= (empty( $student_details[ 'street_address' ] ) ? "N/A" : $student_details[ 'street_address' ]) ?></td>
            </tr>

            <tr>
                <td><b>Colony:</b> <?= (empty( $student_details[ 'colony' ] ) ? "N/A" : $student_details[ 'colony' ]) ?></td>
                <td><b>City:</b> <?= (empty( $student_details[ 'city' ] ) ? "N/A" : $student_details[ 'city' ]) ?></td>
            </tr>

            <tr>
                <td><b>Monthly fee:</b> <?= $student_details[ 'monthly_fee' ] ?></td>
                <td><b>Student status:</b> <?= (empty( $student_details[ 'student_status' ] ) ? "N/A" : ucfirst( $student_details[ 'student_status' ] )) ?></td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
            <h4>Actions</h4>
            <ul style="list-style: circle;">
                <li><a href="#" class="delete_button_modal" data-target="#delete_modal" data-toggle="modal" data-delete-url="<?= site_url( 'admin-dashboard/student_delete?stdid=' . $student_details[ 'student_registration_id' ] . '&redirect=' . urlencode( $redirect_url ) ) ?>" data-registration-no="<?= $student_details[ 'registration_number' ] ?>">Delete</a></li>
                <li><a href="<?= site_url( 'admin-dashboard/student-update?stdid=' . $student_details[ 'student_registration_id' ] . '&redirect=' . urlencode( $redirect_url ) ) ?>">Update</a></li>
                <li><a href="#" class="print_button">Print Details</a></li>
                <li><a href="<?= site_url('fee/receive-fee/' . $student_details[ 'student_registration_id' ] . '?redirect=' . urlencode( $redirect_url )) ?>">Receive Fee</a></li>
            </ul>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12"><a href="<?= $redirect_url ?>"><span class="glyphicon glyphicon-arrow-left"></span> Return back</a></div>
    </div>

</div>

<script type="text/javascript">
    jQuery( function ( $ ) {
        
        $( ".print_button" ).click( function ( e ) {
            
            e.preventDefault();
            
            var prnt = window.open( '' );
            prnt.document.write( '<html><head><title>Print</title></head><body onafterprint="self.close()">' );
            
            var bootstrap = prnt.document.createElement( 'link' );
            bootstrap.rel = 'stylesheet';
            bootstrap.href = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
            prnt.document.head.appendChild( bootstrap );
            
            var tbl = $( ".student_details" ).html();
            
            $( prnt.document.body ).append( '<button type="button" class="btn btn-primary center-block hidden-print" onclick="window.print()">Print</button>' ).append( $( tbl ).find( 'table' ) );
            
        } );
        
    } );
</script>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>