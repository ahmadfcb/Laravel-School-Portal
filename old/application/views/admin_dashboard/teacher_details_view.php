<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

<?php
if ( $teacher_details === false ) {
    echo '<h3>No teacher details were found for requested teacher.</h3>';
} else {
    ?>

    <div class="">
        <img src="<?= base_url( $teacher_details[ 'pic' ] ) ?>" width="150">
    </div>

    <table class="table table-responsive table-no-border">

        <tr>
            <td><b>Name:</b> <?= $teacher_details[ 'name' ] ?></td>
            <td><b>Father's name:</b> <?= $teacher_details[ 'father_name' ] ?></td>
        </tr>

        <tr>
            <td><b>Gender:</b> <?= $teacher_details[ 'gender' ] ?></td>
            <td><b>DOB:</b> <?= $teacher_details[ 'dob' ] ?></td>
        </tr>

        <tr>
            <td><b>CNIC:</b> <?= $teacher_details[ 'cnic' ] ?></td>
            <td><b>Street address:</b> <?= $teacher_details[ 'street_address' ] ?></td>
        </tr>

        <tr>
            <td><b>Colony:</b> <?= $teacher_details[ 'colony' ] ?></td>
            <td><b>City:</b> <?= $teacher_details[ 'city' ] ?></td>
        </tr>

    </table>

    <div><a href=""><span class="glyphicon glyphicon-arrow-left"></span> Back to Teachers</a></div>
    
    <?php
}
?>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>