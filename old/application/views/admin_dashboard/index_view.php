<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


    <div class="admin-panel-home">

        <p>Manage your school from here</p>

    </div>

    <div style="margin-top: 30px;">

        <div class="row">

            <?php if ( $this->admin_user_type_privilege_model->get( $this->session->userdata( 'user_type' ), "admin-dashboard/student-registration" ) !== false ): ?>
                <div class="col-sm-6">
                    <a href="<?= site_url( 'admin-dashboard/student-registration' ) ?>" class="btn btn-lg btn-block btn-primary">New Admission</a>
                </div>
            <?php endif; ?>

            <?php if ( $this->admin_user_type_privilege_model->get( $this->session->userdata( 'user_type' ), "admin-dashboard/students" ) !== false ): ?>
                <div class="col-sm-6">
                    <a href="<?= site_url( "admin-dashboard/students" ) ?>" class="btn btn-lg btn-block btn-primary">Available students</a>
                </div>
            <?php endif; ?>

        </div>

    </div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>