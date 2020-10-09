<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

<?php
// no student registered
if ( $students === false ) {

    // if there is search but there is no result
    if ( !empty( $student_search ) ) {
        echo "<h3>Your search didn't return any student.</h3>";
    } else { // no search no result
        echo '<h3>No student found!</h3>';
    }
} else {
    ?>

    <div class="row">

        <div class="col-sm-12">
            <h4>Filter results</h4>

            <form action="" method="get" id="cust_form1" class="form-inline text-center">
                <div class="form-group">
                    <label>Branch</label>
                    <select name="branch" id="branch_DropDown" class="form-control">
                        <option value="" <?= set_select( 'branch', '', TRUE ) ?> ></option>
                        <option value="KG" <?= set_select( 'branch', 'KG' ) ?> >KG</option>
                        <option value="Junior" <?= set_select( 'branch', 'Junior' ) ?> >Junior</option>
                        <option value="Girls High" <?= set_select( 'branch', 'Girls High' ) ?> >Girls High</option>
                        <option value="Boys High" <?= set_select( 'branch', 'Boys High' ) ?> >Boys High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Class</label>
                    <select name="class" class="form-control">
                        <option value="" <?= set_select( 'class', '', TRUE ) ?> ></option>
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
                        <option value="" <?= set_select( 'section', '', TRUE ) ?> ></option>
                        <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                        <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                        <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                        <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                        <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="q" placeholder="Search students" value="<?= set_value( 'q' ) ?>">
                    <!--<p class="help-block small">You can search <u>First name</u>, <u>Last name</u> and
                        <u>registration number</u> of the student and <u>CNIC</u> of father from here.</p>-->
                </div>

                <div class="form-group">
                    <label><input type="checkbox" name="withdrawn" value="true" <?= set_checkbox( 'withdrawn', 'true' ) ?>> Only show withdrawn students?</label>
                </div>
            </form>

            <div class="text-center">
                <button class="btn btn-primary cust_form_btn" type="button" data-url="<?= current_url() ?>" data-target="#cust_form1">Search</button>

                <button class="btn btn-primary cust_form_btn" type="button" data-url="<?= site_url( 'admin-dashboard/attendance-sheet' ) ?>" data-target="#cust_form1">Get Attendance Sheet</button>

                <p class="help-block">For attendance sheet: Branch, Class, Section is required.</p>
            </div>

        </div>

    </div>

    <h3><?= ( $withdrawn === false ? "Available students" : "Withdrawn students" ) ?>
        <small>(Total: <?= $students_count['total'] ?>, Male: <?= $students_count['male'] ?>, Female: <?= $students_count['female'] ?>)</small>
    </h3>

    <button type="button" class="print_target btn btn-default center-block" style="margin-top: 5px; margin-bottom: 10px;" data-target="#cust_form">Print</button>

    <div class="table-responsive" id="available_students_container">

        <?= '<h4 class="visible-print">' . $current_search_string . '</h4>' ?>

        <form action="" method="post" class="cust_form" id="cust_form">
            <div class="visible-print text-center" style="margin-bottom: 5px;">Total: <?= $students_count['total'] ?>, Male: <?= $students_count['male'] ?>, Female: <?= $students_count['female'] ?></div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="hidden-print"></th>
                        <?= ( $show_roll_no === true && $withdrawn === false ? "<th>Roll#</th>" : "" ) ?>
                        <th>PIN</th>
                        <th>Reg#</th>
                        <th>Student Name /<br>Father Name</th>
                        <th class="hidden-print">School Branch /<br>Current Class /<br>Section</th>

                        <th>Date Of Birth /<br>Gender</th>

                        <th>Colony /<br>City /<br>Address</th>

                        <?php if ( $withdrawn === true ): ?>
                            <th>Leave certificate</th>
                            <th>Withdrawn time</th>
                            <th>Comments regarding withdrawal</th>
                        <?php endif; ?>

                        <?php if($is_admin === 1): ?>
                            <th>Phone</th>
                        <?php endif; ?>

                        <th>Student status</th>

                        <th>Picture</th>

                        <th class="hidden-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ( $students as $key => $std ) {
                        ?>
                        <tr>
                            <td class="hidden-print">
                                <input type="checkbox" name="reg_number[]" value="<?= $std['registration_number'] ?>">
                            </td>
                            <?= ( $show_roll_no === true && $withdrawn === false ? "<td>" . ( $key + 1 ) . "</td>" : "" ) ?>
                            <td><?= $std['registration_number'] ?></td>
                            <td><?= $std['registration_new'] ?></td>
                            <td>
                                <a style="color: #666;" href="<?= site_url( 'admin-dashboard/view-student?stdid=' . $std['student_registration_id'] . '&redirect=' . urlencode( $redirect_url ) ) ?>" title="Open student details"><?= $std['first_name'] ?> <?= $std['last_name'] ?></a>
                                <br><?= $std['father_name'] ?>
                            </td>

                            <td class="hidden-print">
                                <?= $std['school_branch'] ?>
                                <br><?= $std['current_class'] ?>
                                <br><?= $std['section'] ?>
                            </td>

                            <td>
                                <?= $std['dob'] ?>
                                <br><?= ucfirst($std['gender']) ?>
                            </td>

                            <td>
                                <?= $std['colony'] ?>
                                <br><?= $std['city'] ?>
                                <br><?= $std['street_address'] ?>
                            </td>

                            <?php if ( $withdrawn === true ): ?>
                                <td><?= ( empty( $std['leave_certificate_granted'] ) ? "Not granted" : "Granted" ) ?></td>
                                <td><?= ( empty( $std['withdrawn_time'] ) ? "N/A" : $std['withdrawn_time'] ) ?></td>
                                <td><?= ( empty( $std['comments'] ) ? "N/A" : $std['comments'] ) ?></td>
                            <?php endif; ?>

                            <?php if($is_admin === 1): ?>
                                <td><?= $std['father_mobile'] ?></td>
                            <?php endif; ?>

                            <td><?= ( !empty( $std['student_status'] ) && $std['student_status'] == 'active' ? "Active" : "Withdrawn" ) ?></td>

                            <td>
                                <img src="<?= base_url($std['profile_pic']) ?>" style="max-width: 100%; max-height: 60px;">
                            </td>

                            <td class="hidden-print">
                                <a class="btn btn-default btn-xs" href="<?= site_url( 'fee/receive-fee/' . $std['student_registration_id'] ) . '?redirect=' . urlencode( $redirect_url ) ?>" title="Receive Fee"><i class="fa fa-money"></i></a>
                                <a class="btn btn-default btn-xs" href="<?= site_url('admin-dashboard/student-update') . '?stdid=' . $std['student_registration_id'] . '&redirect_url=' . urlencode($redirect_url) ?>" title="Edit record"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </form>

    </div>

    <div class="text-center">

        <button data-url='<?= site_url( 'admin-dashboard/reg-card-get' ) ?>' data-target="#cust_form" type="button" class="btn btn-primary cust_form_btn">Print Card(s)</button>

        <button data-url='<?= site_url( 'admin-dashboard/general-sms' ) ?>' data-target="#cust_form" type="button" class="btn btn-primary cust_form_btn">Send SMS</button>

        <?php if ( $show_roll_no === true ): ?>
            <a href="<?= site_url( 'admin-dashboard/attendance-sheet' ) . '?branch=' . $branch . '&class=' . $class . '&section=' . $section ?>" class="btn btn-primary">Get Attendance Sheet</a>
        <?php endif; ?>
    </div>

    <script>
        jQuery( function ( $ ) {

            // Managing print button
            $( "#available_students_print" ).click( function () {

                var reg_std_print = window.open( '' );
                reg_std_print.document.write( '<html><head><title>Print</title></head><body onafterprint="self.close()"></body></html>' );

                var bootstrap = reg_std_print.document.createElement( 'link' );
                bootstrap.rel = 'stylesheet';
                bootstrap.href = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css';
                reg_std_print.document.head.appendChild( bootstrap );

                $( reg_std_print.document.body ).append( $( "#available_students_container" ).html() ).prepend( '<button type="button" class="btn btn-primary center-block hidden-print" onclick="window.print()">Print</button>' );

                $( reg_std_print.document.body ).find( 'table' ).addClass( 'table-bordered' ).css( 'border' );

                $( reg_std_print.document.body ).find( 'table tbody tr' ).each( function ( i, d ) {
                    $( this ).find( 'td' ).each( function ( ii, dd ) {
                        $( this ).html( $( this ).text() );
                    } );
                } );

            } );

        } );
    </script>

    <?php
}
?>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>