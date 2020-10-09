<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>



<div class="row">
    <div class="col-sm-6 col-sm-offset-1">

        <p class="help-block">Select branch, class and section to get list of students.</p>

        <form method="post" action="<?= current_url() ?>">
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

            <div class="form-group">
                <label>Filter from</label>
                <input type="date" name="from_date" class="form-control" value="<?= set_value( 'from_date' ) ?>" placeholder="YYYY-MM-DD">
            </div>

            <div class="form-group">
                <label>Filter to</label>
                <input type="date" name="to_date" class="form-control" value="<?= set_value( 'to_date' ) ?>" placeholder="YYYY-MM-DD">
            </div>

            <div class="text-center">
                <!-- Button -->
                <button style="width: 50%;" type="submit" id="submit" name="submit" class="form contact-form-button light-form-button oswald light">Get Fee Paid Details</button>
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
                <h2>Details of students of this class</h2>

                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>CNIC</th>
                            <th>Father's name</th>
                            <th>Remaining dues</th>
                            <th>Fee payment date</th>
                            <th>Paid Fee</th>
                            <th>Generated<br>Voucher</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ( $student_details as $std ):
                            ?>
                            <tr>
                                <td><?= $std[ 'first_name' ] . ' ' . $std[ 'last_name' ] ?></td>
                                <td><?= $std[ 'cnic' ] ?></td>
                                <td><?= $std[ 'father_name' ] ?></td>
                                <td>Rs. <?= $std[ 'total_fee_due' ] ?></td>
                                <td><?= (empty( $std[ 'fee_paid_date' ] ) ? "N/A" : date( 'd-m-Y', strtotime( $std[ 'fee_paid_date' ] ) ) ) ?></td>
                                <td><?= (empty( $std[ 'amount' ] ) ? "N/A" : "Rs. " . $std[ 'amount' ]) ?></td>
                                <td><?= (empty( $std[ 'voucher_id' ] ) ? "N/A" : "<a href='" . site_url( 'admin-dashboard/fee-voucher-get/' . $std[ 'voucher_id' ] ) . "' target='_blank'>View</a>") ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>

    </div>

<?php endif; ?>


<?php if ( $fee_paid_statistics !== null ): ?>

    <hr class="bottom-line" style="margin-top: 30px; margin-bottom: 30px;">


    <div class="payment_statistics table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="2"><h3 class="heading">Payment Statistics</h3></th>
                </tr>

                <tr>
                    <th>Paid during selected interval</th>
                    <th>Remaining student fee till now</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rs. <?= $fee_paid_statistics[ 'paid_fee' ] ?></td>
                    <td>Rs. <?= $fee_paid_statistics[ 'total_remaining_dues' ] ?></td>
                </tr>
            </tbody>
        </table>

    </div>

<?php endif; ?>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>