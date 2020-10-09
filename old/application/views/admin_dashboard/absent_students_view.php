<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


    <div class="row">
        <div class="col-sm-12">

            <p class="help-block">Select branch, class and section to get list of students.</p>

            <form method="get" action="<?= current_url() ?>" class="form-inline">
                <div class="form-group">
                    <label>Branch</label>

                    <select name="school_branch" id="branch_DropDown" class="form-control">
                        <option value="" <?= set_select( 'school_branch', '' ) ?> >--Select--</option>
                        <option value="KG" <?= set_select( 'school_branch', 'KG' ) ?> >KG</option>
                        <option value="Junior" <?= set_select( 'school_branch', 'Junior' ) ?> >Junior</option>
                        <option value="Girls High" <?= set_select( 'school_branch', 'Girls High' ) ?> >Girls High</option>
                        <option value="Boys High" <?= set_select( 'school_branch', 'Boys High' ) ?> >Boys High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Current Class</label>
                    <select name="current_class" class="form-control">
                        <option value="" <?= set_select( 'current_class', '' ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'current_class', 'Toddlers' ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'current_class', 'LKG' ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'current_class', 'UKG' ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'current_class', '1st' ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'current_class', '2nd' ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'current_class', '3rd' ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'current_class', '4th' ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'current_class', '5th' ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'current_class', '6th' ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'current_class', '7th' ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'current_class', '8th' ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'current_class', '9th' ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'current_class', '10th' ) ?> >10th</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Section</label>
                    <select name="section" class="form-control">
                        <option value="" <?= set_select( 'section', '' ) ?> >--Select--</option>
                        <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                        <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                        <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                        <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                        <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
                    </select>
                </div>

                <div class="text-center">
                    <!-- Button -->
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Get class students</button>
                </div>

            </form>

        </div>
    </div>


<?php if ( $student_details !== null ): // User didn't submit the form ?>

    <div class="row">

        <?php if ( $student_details === false ): // no student found. ?>
            <div class="col-xs-12">
                <h2>No students available in this class</h2>
            </div>
        <?php else: // student found ?>

            <div class="col-xs-12">
                <h2>Active students of the class</h2>
                <p class="help-block">Students can be marked absent only once for a day, even if you select them multiple times.</p>
            </div>

            <form action="<?= site_url( 'admin-dashboard/absent-students-process' ) . '?redirect=' . urlencode( $redirect_url ) ?>" method="post">
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>PIN</th>
                            <th>Reg#</th>
                            <th>Name</th>
                            <th>Father's name</th>
                            <th>Gender</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ( $student_details as $std ): ?>
                            <tr>
                                <td>
                                    <input type='checkbox' name="stdid[]" value="<?= $std['student_registration_id'] ?>">
                                </td>
                                <td><?= $std['registration_number'] ?></td>
                                <td><?= $std['registration_new'] ?></td>
                                <td><?= $std['first_name'] . ' ' . $std['last_name'] ?></td>
                                <td><?= $std['father_name'] ?></td>
                                <td><?= $std['gender'] ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>

                <div class="col-sm-6 col-sm-offset-1">

                    <div class="form-group">
                        <label>Send SMS</label>
                        <select name="send_sms" id="send_sms" class="form-control" required="">
                            <option value="yes" <?= set_select( 'send_sms', 'yes' ) ?>>Yes</option>
                            <option value="no" <?= set_select( 'send_sms', 'no' ) ?>>No</option>
                        </select>
                    </div>

                    <div class="sms_related">
                        <div class="form-group">
                            <label>SMS templates</label>
                            <div>
                                <?php
                                if ( $sms_templates === false ):
                                    echo '<p>No SMS templates found!</p>';
                                else:
                                    ?>
                                    <ul class="list-unstyled">
                                        <?php
                                        foreach ( $sms_templates as $temp ):
                                            ?>

                                            <li>
                                                <a href="#" class="sms-template" title="<?= $temp['sms_template_body'] ?>"><?= substr( $temp['sms_template_body'], 0, 50 ) . ( strlen( $temp['sms_template_body'] ) > 50 ? "..." : "" ) ?></a>
                                            </li>

                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                    <?php
                                endif;
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Message for parents</label>
                            <textarea class="form-control" name="message" id="msg" placeholder="Message for parents" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Absent date</label>
                        <p class="help-block">Leave empty if N/A</p>
                        <input type="date" name="absent_date" class="form-control" placeholder="i.e. 2017-12-30">
                    </div>

                    <!-- Button -->
                    <div class="text-center">
                        <button style="width: 50%;" type="submit" name="submit" class="form contact-form-button light-form-button oswald light">Mark student as Absent</button>
                    </div>
                </div>
            </form>

        <?php endif; ?>

    </div>

<?php endif; ?>

    <script>
        jQuery( function ( $ ) {

            $( ".sms-template" ).click( function ( e ) {
                e.preventDefault();
                $( "#msg" ).val( $( this ).text() );
            } );

            $( "#send_sms" ).on( 'change', function () {
                if ( $( this ).val() == 'yes' ) {
                    $( '.sms_related' ).slideDown();
                } else {
                    $( '.sms_related' ).slideUp();
                }
            } );

        } );
    </script>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>