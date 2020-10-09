<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>



    <div class="row">

        <div class="col-sm-12 text-center">

            <form action="" method="get" class="form-inline">
                <div class="form-group">
                    <label>Branch</label>
                    <select name="branch" id="branch_DropDown" class="form-control">
                        <option value="" <?= set_select( 'branch', '', TRUE ) ?> >--Select--</option>
                        <option value="KG" <?= set_select( 'branch', 'KG' ) ?> >KG</option>
                        <option value="Junior" <?= set_select( 'branch', 'Junior' ) ?> >Junior</option>
                        <option value="Girls High" <?= set_select( 'branch', 'Girls High' ) ?> >Girls High</option>
                        <option value="Boys High" <?= set_select( 'branch', 'Boys High' ) ?> >Boys High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Class</label>
                    <select name="class" class="form-control">
                        <option value="" <?= set_select( 'class', '', TRUE ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'class', 'Toddlers' ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'class', 'LKG' ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'class', 'UKG' ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'class', '1st' ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'class', '2nd' ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'class', '3rd' ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'class', '4th' ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'class', '5th' ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'class', '6th' ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'class', '7th' ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'class', '8th' ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'class', '9th' ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'class', '10th' ) ?> >10th</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Section</label>
                    <select name="section" class="form-control">
                        <option value="" <?= set_select( 'section', '', TRUE ) ?> >--Select--</option>
                        <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                        <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                        <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                        <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                        <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Report from</label>
                    <input type="date" name="report_from" value="<?= set_value( 'report_from', date( "Y-m-d", now() ) ) ?>" class="form-control" placeholder="e.g. 2017-08-01">
                </div>

                <div class="form-group">
                    <label>Report to</label>
                    <input type="date" name="report_to" value="<?= set_value( 'report_to', date( "Y-m-d", now() ) ) ?>" class="form-control" placeholder="e.g. 2017-08-01">
                </div>

                <div class="form-group">
                    <label>Search in the records</label>
                    <input type="text" class="form-control" name="q" placeholder="Search students" value="<?= set_value( 'q' ) ?>">
                    <!--<p class="help-block small">You can search through <u>First name</u>, <u>Last name</u>, and <u>registration number</u> of the student or <u>Father's CNIC</u> from here.</p>-->
                </div>

                <div>
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

        </div>

    </div>

<?php if ( $student_details !== null ): ?>
    <div class="table-responsive">

        <?php if ( $student_details === false ): ?>
            <h3>No record found</h3>
        <?php else: ?>

            <h3>Following students were absent <small>(Total: <?= count( $student_details ) ?>)</small></h3>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Reg#</th>
                        <th>Name</th>
                        <th>Father/Guardian Name</th>
                        <th>School Branch</th>
                        <th>Current Class</th>
                        <th>Section</th>
                        <th>Absent Date</th>
                        <th>Number of absents</th>
                        <?php if ( $dates_provided === true ): ?>
                            <th># of absents</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ( $student_details as $std ): ?>

                        <tr>
                            <td><?= $std[ 'registration_number' ] ?></td>
                            <td><a style="color: #666;" href="<?= site_url( 'admin-dashboard/view_student' ) . "?stdid=" . $std[ 'student_registration_id' ] ?>"><?= $std[ 'first_name' ] . ' ' . $std[ 'last_name' ] ?></a></td>
                            <td><?= $std[ 'father_name' ] ?></td>
                            <td><?= $std[ 'school_branch' ] ?></td>
                            <td><?= $std[ 'current_class' ] ?></td>
                            <td><?= $std[ 'section' ] ?></td>
                            <td><?= date( "d-M-Y", strtotime( $std[ 'attendance_date' ] ) ) ?></td>
                            <td><?= $std['absent_count'] ?></td>
                            <?php if ( $dates_provided === true ): ?>
                                <td><?= $this->general_model->calculate_absents( $std[ 'student_registration_id' ], $report_from, $report_to ); ?></td>
                            <?php endif; ?>
                        </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>


        <?php endif; ?>

    </div>
<?php endif; ?>



<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>