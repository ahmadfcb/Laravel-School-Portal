<?php $this->load->view( "templates/main_header_view" ) ?>

<?php $admin_user_type_privileges = $this->admin_user_type_privilege_model->get( $this->session->userdata( 'user_type' ) ) ?>


<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="header-section text-center">
                <h2><?= $title ?></h2>
                <hr class="bottom-line">
            </div>

            <div class="col-sm-3">
                <ul class="nav nav-pills nav-stacked dashboard-links">
                    <?php
                    if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard', $admin_user_type_privileges ) ):
                        ?>
                        <li>
                            <a role="presentation" href="<?= site_url( "admin-dashboard" ) ?>"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span><span class=""> Admin Panel Home</span></a>
                        </li>
                        <?php
                    endif;
                    ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array('admin-dashboard/student-registration', 'admin-dashboard/students', 'admin-dashboard/leave-certificate'), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Student info
                                <span class="caret"></span></a>
                            <ul>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/student-registration', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/student-registration" ) ?>">Student registration</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/students', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/students" ) ?>">Registered Students</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/leave-certificate', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/leave-certificate" ) ?>">Character/Leave Certificate</a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <a role="presentation" href="<?= site_url( "students/new_students" ) ?>">New Students</a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array('student-attendance', 'student-attendance/report'), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Student Attendance
                                <span class="caret"></span></a>
                            <ul>
                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'student-attendance', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "student-attendance" ) ?>">Student Attendance</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'student-attendance/report', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "student-attendance/report" ) ?>">Student Attendance Report</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array('admin-dashboard/promote-demote-students', "admin-dashboard/withdraw"), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> Actions
                                <span class="caret"></span></a>
                            <ul>
                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/promote-demote-students', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/promote-demote-students" ) ?>">Promote/Demote Students</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/withdraw', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/withdraw" ) ?>">Withdraw/Re-admit</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/payment-settings', $admin_user_type_privileges ) ): ?>
                        <li>
                            <a role="presentation" href="<?= site_url( "admin-dashboard/payment-settings" ) ?>"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Payment Settings</a>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array("admin-dashboard/add-datesheet", "admin-dashboard/add-news"), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
                                <span class="caret"></span></a>
                            <ul>
                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/add-datesheet', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/add-datesheet" ) ?>">Add Datesheet</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/add-news', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/add-news" ) ?>">Add News/Events</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array("admin-dashboard/add-teacher", "admin-dashboard/teachers"), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Teachers
                                <span class="caret"></span></a>
                            <ul>
                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/add-teacher', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/add-teacher" ) ?>">Add Teacher</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/teachers', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/teachers" ) ?>">Teachers</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array("admin-dashboard/sms-templates"), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> SMS
                                <span class="caret"></span></a>
                            <ul>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/sms-templates', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/sms-templates" ) ?>">SMS templates</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array("admin-dashboard/create-accounts"), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Account
                                <span class="caret"></span></a>
                            <ul>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/create-accounts', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/create-accounts" ) ?>">Accounts</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/change-password', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/change-password" ) ?>">Change password</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array("admin-dashboard/best-students", "admin-dashboard/time-table"), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Application
                                <span class="caret"></span></a>
                            <ul>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/best-students', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/best-students" ) ?>">Best students</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'admin-dashboard/time-table', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "admin-dashboard/time-table" ) ?>">Timetable</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ( $this->admin_user_type_privilege_model->filter_privileges( array("fee/defaulters", "fee/today-collection", "fee/overall-statistics"), $admin_user_type_privileges ) ): ?>
                        <li class="cus_drop">
                            <a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Fee
                                <span class="caret"></span></a>
                            <ul>
                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'fee/receive_fee_form', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "fee/receive_fee_form" ) ?>">Fee Receive</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'fee/defaulters', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "fee/defaulters" ) ?>">Fee defaulters</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'fee/today-collection', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "fee/today-collection" ) ?>">Today's collection</a>
                                    </li>
                                <?php endif; ?>

                                <?php if ( $this->admin_user_type_privilege_model->filter_privileges( 'fee/overall-statistics', $admin_user_type_privileges ) ): ?>
                                    <li>
                                        <a role="presentation" href="<?= site_url( "fee/overall-statistics" ) ?>">Overall statistics</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                <script type="text/javascript">
                    jQuery( function ( $ ) {

                        $( '.cus_drop' ).on( 'click', function ( e ) {
                            e.preventDefault();
                            $( this ).children( 'ul' ).slideToggle();
                        } );

                        $( '.cus_drop > ul > li' ).click( function ( e ) {
                            e.stopPropagation();
                        } );

                    } );
                </script>
            </div>

            <div class="col-sm-9">