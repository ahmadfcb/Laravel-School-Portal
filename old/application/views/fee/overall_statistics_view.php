<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<div>
    <form action="" method="get" class="form-inline">

        <div class="form-group">
            <label>Branch</label>

            <select name="school_branch" id="branch_DropDown" class="form-control">
                <option value="" <?= set_select( 'school_branch', '', TRUE ) ?> >--Select--</option>
                <option value="KG" <?= set_select( 'school_branch', 'KG' ) ?> >KG</option>
                <option value="Junior" <?= set_select( 'school_branch', 'Junior' ) ?> >Junior</option>
                <option value="Girls High" <?= set_select( 'school_branch', 'Girls High' ) ?> >Girls High</option>
                <option value="Boys High" <?= set_select( 'school_branch', 'Boys High' ) ?> >Boys High</option>
            </select>
        </div>

        <div class="form-group">
            <label>Class</label>
            <select name="current_class" class="form-control">
                <option value="" <?= set_select( 'current_class', '', TRUE ) ?> >--Select--</option>
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
                <option value="" <?= set_select( 'section', '', TRUE ) ?> >--Select--</option>
                <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date from</label>
            <input type="date" class="form-control" name="date_from" value="<?= set_value( 'date_from' ) ?>" placeholder="i.e. 2017-01-15">
        </div>

        <div class="form-group">
            <label>Date to</label>
            <input type="date" class="form-control" name="date_to" value="<?= set_value( 'date_to' ) ?>" placeholder="i.e. 2017-01-30">
        </div>

        <div class="form-group">
            <label>Search</label>
            <input type="text" class="form-control" name="search" value="<?= set_value( 'search' ) ?>">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>

    </form>
</div>

<div class="row">
    <div class="col-sm-12">
        <h3>Payment records</h3>

        <?php
        if ( $payment_records === false ):
            echo "<p>No record found yet!</p>";
        else:
            ?>
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Payment date</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Reg#</th>
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
                            <th>Sub total</th>
                            <th>Remission</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ( $payment_records as $prc ):
                            ?>
                            <tr>
                                <td><?= date( 'Y/m/d', strtotime( $prc['fp_payment_datetime'] ) ) ?></td>
                                <td><?= $prc['first_name'] . ' ' . $prc['last_name'] ?></td>
                                <td><?= $prc['school_branch'] ?></td>
                                <td><?= $prc['current_class'] ?></td>
                                <td><?= $prc['section'] ?></td>
                                <td><?= $prc['registration_number'] ?></td>
                                <td><?= $prc['fp_admission_fee'] ?></td>
                                <td><?= $prc['fp_registration_fee'] ?></td>
                                <td><?= $prc['fp_tuition_fee'] ?></td>
                                <td><?= $prc['fp_exam_fee'] ?></td>
                                <td><?= $prc['fp_computer_fee'] ?></td>
                                <td><?= $prc['fp_fine'] ?></td>
                                <td><?= $prc['fp_other1'] ?></td>
                                <td><?= $prc['fp_other2'] ?></td>
                                <td><?= $prc['fp_other3'] ?></td>
                                <td><?= $prc['fp_payable_within_due_date'] ?></td>
                                <td><?= $prc['fp_payable_after_due_date'] ?></td>
                                <td><?= $prc['fp_total_fee'] ?></td>
                                <td><?= $prc['fp_remission'] ?></td>
                                <td><?= $prc['fp_paid_fee'] ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>

                <h5 class="text-right"><?= "Payment record grand total: " . $payment_records_grand_total ?></h5>

            </div>
            <?php
        endif;
        ?>

    </div>

    <div class="col-sm-12">
        <h3>Tuition fee during <?= ( empty( $date_from ) && empty( $date_to ) ? "current month" : "selected duration <small>(" . date( 'd/m/Y', strtotime( $date_from ) ) . " - " . date( 'd/m/Y', strtotime( $date_to ) ) . ")</small>" ) ?></h3>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Expected fee</th>
                        <th>Paid fee</th>
                        <th>Not paid Fee</th>
                        <th>Pending fee</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Rs. <?= $fee_expected ?></td>
                        <td>Rs. <?= $fee_paid ?></td>
                        <td>Rs. <?= $fee_not_paid ?></td>
                        <td>Rs. <?= $fee_pending ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-sm-12">
        <h3>Pending dues</h3>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Arears</th>
                        <th>Exam fee</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Rs. <?= $total_arears ?></td>
                        <td>Rs. <?= $exam_fee_arears ?></td>
                        <td>Rs. <?= $total_arears + $exam_fee_arears ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!--
    Pending exam fee


    Pending arears
        sum of arears from the student table
        +
        Current month not paid
    -->

</div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>
