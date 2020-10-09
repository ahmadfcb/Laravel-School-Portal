<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<?php
if ( $teachers_details === false ) {
    echo '<h3>Currently there is no information for any teacher.</h3>';
} else {
    ?>
    <table class="table table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Father's name</th>
                <th>Gender</th>
                <th>CNIC</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ( $teachers_details as $td ):
                ?>
                <tr>
                    <td><?= $td[ 'name' ] ?></td>
                    <td><?= $td[ 'father_name' ] ?></td>
                    <td><?= $td[ 'gender' ] ?></td>
                    <td><?= $td[ 'cnic' ] ?></td>
                    <td><a href="<?= site_url('admin-dashboard/teacher-details/' . $td['teacher_id']) ?>">View details</a></td>
                </tr>
                <?php
            endforeach;
            ?>
        </tbody>
    </table>

    <?php
}
?>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>