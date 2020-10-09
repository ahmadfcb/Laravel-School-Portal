<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>

    <p>
        <a href="<?= $redirect_url ?>"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
    </p>

    <div class="row">

        <div class="col-sm-5">
            <h3>Fee Details</h3>

            <form action="<?= site_url( 'fee/receive-fee-process/' . $student_details['student_registration_id'] ) ?>" method="POST">

                <p class="help-block">Fill all the applicable fields and leave others empty!</p>

                <div class="form-group">
                    <label>
                        <input type="checkbox" id="advance_fee" name="advance_fee" value="1"> Advance fee
                    </label>
                </div>

                <div class="form-group">
                    <label>Admission Fee</label>
                    <input type="text" name="adm_fee" value="<?= set_value( 'adm_fee' ) ?>" class="form-control" autofocus>
                </div>

                <div class="form-group">
                    <label>Registration Fee</label>
                    <input type="text" name="reg_fee" value="<?= set_value( 'reg_fee' ) ?>" class="form-control">
                </div>

                <div class="form-group" id="advance_fee_input" style="display: none;">
                    <label>Fee for no# of months</label>
                    <p class="help-block">This student has Rs. <?= $student_details['monthly_fee'] ?> per month</p>
                    <input type="number" name="fee_for_number_of_months" value="<?= set_value( 'fee_for_number_of_months', 0 ) ?>" class="form-control">
                </div>

                <div class="form-group" id="tuition_fee">
                    <label>Tuition Fee</label>
                    <select name="tuition_fee" class="form-control">
                        <option value="0" <?= set_select( 'tuition_fee', '0' ) ?>>0</option>
                        <?php
                        if ( $current_month_fee_details !== false ) {
                            if ( $current_month_fee_details['monthly_fee_detail_paid_status'] == 2 ) {
                                echo '<option value="' . $current_month_fee_details['monthly_fee_detail_amount'] . '" ' . set_select( 'tuition_fee', $current_month_fee_details['monthly_fee_detail_amount'], true ) . '>' . $current_month_fee_details['monthly_fee_detail_amount'] . '</option>';
                            }
                        } else {
                            echo "<option value='" . $student_details['monthly_fee'] . "' " . set_select( 'tuition_fee', $student_details['monthly_fee'], true ) . ">" . $student_details['monthly_fee'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Computer Fee</label>
                    <input type="text" name="comp_fee" value="<?= set_value( 'comp_fee' ) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Exam Fee</label>
                    <input type="text" name="exam_fee" value="<?= set_value( 'exam_fee', $student_details['exam_fee_arears'] ) ?>" class="form-control">
                </div>

                <div class="arears">
                    <label>Arears</label>
                    <input type="text" name="arears" value="<?= set_value( 'arears', $student_details['arears'] ) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Fine</label>
                    <input type="text" name="fine" value="<?= set_value( 'fine' ) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Other1</label>
                    <input type="text" name="other1" value="<?= set_value( 'other1' ) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Other2</label>
                    <input type="text" name="other2" value="<?= set_value( 'other2' ) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Other3</label>
                    <input type="text" name="other3" value="<?= set_value( 'other3' ) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label>Remission</label>
                    <input type="text" name="remission" value="<?= set_value( 'remission' ) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Receive Fee</button>
                </div>

            </form>
        </div>

        <div class="col-sm-7">

            <h3>Student Information</h3>

            <div class="table-responsive">

                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td><?= $student_details['first_name'] . ' ' . $student_details['last_name'] ?></td>
                        </tr>

                        <tr>
                            <th>Father's name</th>
                            <td><?= $student_details['father_name'] ?></td>
                        </tr>

                        <tr>
                            <th>Fee for current month</th>
                            <td>
                                <?php
                                if ( $current_month_fee_details !== false ) {
                                    switch ( $current_month_fee_details['monthly_fee_detail_paid_status'] ) {
                                        case '0':
                                            echo "Not paid";
                                            break;
                                        case 1:
                                            echo "<i class=\"fa fa-thumbs-up\" aria-hidden=\"true\"></i> Paid <small>(" . $current_month_fee_details['monthly_fee_detail_amount'] . ")</small>";
                                            break;
                                        case 2:
                                            echo "<i class=\"fa fa-clock-o\" aria-hidden=\"true\"></i> Pending <small>(" . $current_month_fee_details['monthly_fee_detail_amount'] . ")</small>";
                                            break;
                                    }
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Arears</th>
                            <td>Rs. <?= $student_details['arears'] ?></td>
                        </tr>

                        <tr>
                            <th>Exam Fee Arears</th>
                            <td>Rs. <?= $student_details['exam_fee_arears'] ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <h3>Monthly tuition fee history
                <small>(last 6)</small>
            </h3>

            <?php
            if ( $fee_history === false ) {
                echo "<p class='text-center'>No fee history found!</p>";
            } else {

                ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month/Year</th>
                                <th>Due Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ( $fee_history as $feeh ):
                                ?>
                                <tr>
                                    <td><?= date( 'm/Y', strtotime( $feeh['monthly_fee_detail_date'] ) ) ?></td>
                                    <td><?= $feeh['monthly_fee_detail_amount'] ?></td>
                                    <td>
                                        <?php
                                        switch ( $feeh['monthly_fee_detail_paid_status'] ) {
                                            case 0:
                                                echo '<i class="fa fa-ban" aria-hidden="true"></i> Not paid';
                                                break;
                                            case 1:
                                                echo '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Paid';
                                                break;
                                            case 2:
                                                echo '<i class="fa fa-clock-o" aria-hidden="true"></i> Pending';
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            ?>

            <h3>Overall payment history
                <small>(last 6)</small>
            </h3>
            <?php
            if ( $overall_payment_history === false ):
                echo '<p>No payment history found!</p>';
            else:
                ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date/Time</th>
                                <th>Admission fee</th>
                                <th>Registration fee</th>
                                <th>Tuition fee</th>
                                <th>Exam fee</th>
                                <th>Computer fee</th>
                                <th>Fine</th>
                                <th>Other 1</th>
                                <th>Other 2</th>
                                <th>Other 3</th>
                                <th>Payable within due date</th>
                                <th>Payable after due date</th>
                                <th>Remission</th>
                                <th>Sub total</th>
                                <th>Grand total</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            foreach ( $overall_payment_history as $oph ):
                                ?>
                                <tr>
                                    <td><?= date( 'd/m/Y H:i:s', strtotime( $oph['fp_payment_datetime'] ) ) ?></td>
                                    <td><?= $oph['fp_admission_fee'] ?></td>
                                    <td><?= $oph['fp_registration_fee'] ?></td>
                                    <td><?= $oph['fp_tuition_fee'] ?></td>
                                    <td><?= $oph['fp_exam_fee'] ?></td>
                                    <td><?= $oph['fp_computer_fee'] ?></td>
                                    <td><?= $oph['fp_fine'] ?></td>
                                    <td><?= $oph['fp_other1'] ?></td>
                                    <td><?= $oph['fp_other2'] ?></td>
                                    <td><?= $oph['fp_other3'] ?></td>
                                    <td><?= $oph['fp_payable_within_due_date'] ?></td>
                                    <td><?= $oph['fp_payable_after_due_date'] ?></td>
                                    <td><?= $oph['fp_remission'] ?></td>
                                    <td><?= $oph['fp_total_fee'] ?></td>
                                    <td><?= $oph['fp_paid_fee'] ?></td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            endif;
            ?>

        </div>

    </div>

    <script type="text/javascript">
        jQuery( function ( $ ) {

            function advance_fee_manage() {
                if ( $( "#advance_fee" ).prop( 'checked' ) === true ) {
                    $( "#advance_fee_input" ).fadeIn();
                    $( "#tuition_fee" ).hide();
                } else {
                    $( "#advance_fee_input" ).hide();
                    $( "#tuition_fee" ).fadeIn();
                }
            }

            advance_fee_manage();

            $( "#advance_fee" ).click( function () {
                advance_fee_manage();
            } );

        } );
    </script>

<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>