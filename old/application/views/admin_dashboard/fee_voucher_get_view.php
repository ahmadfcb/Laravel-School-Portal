<?php $this->load->view( 'templates/blank_page_header' ) ?>


<div class="fee-voucher-container">

    <button class="btn btn-primary hidden-print" onclick="window.print()" style="margin: 15px;">Print</button>
    
    <br>

    <div class="fee-voucher-content-container">

        <div class="fee-voucher-content-inner">

            <div class="fee-voucher-header">
                <div class="fee-voucher-image"><img src="<?= base_url( 'img/prime-foundation-logo.png' ) ?>" width="70"></div>

                <h2 class="fee-voucher-title">Prime foundation school system</h2>
            </div>

            <div class="fee-voucher-body">
                <table class="table table-responsive table-no-border">
                    <tbody>
                        <tr>
                            <td>Challan No: <?= $fee_voucher_details[ 'voucher_id' ] ?></td>
                            <td class="text-right">Due date: <?= date( 'd-m-Y', strtotime( $fee_voucher_details[ 'voucher_valid_till' ] ) ) ?></td>
                        </tr>

                        <tr>
                            <td>Student ID# <?= $student_details[ 'student_registration_id' ] ?></td>
                            <td class="text-right">Student Registration# <?= $student_details[ 'registration_number' ] ?></td>
                        </tr>

                        <tr>
                            <td>Name:</td>
                            <td>
                                <?= $student_details[ 'first_name' ] . ' ' . $student_details[ 'last_name' ] . ($student_details[ 'gender' ] == 'male' ? ' S/O ' : ' D/O ') . $student_details[ 'father_name' ] ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Class:</td>
                            <td><?= $student_details[ 'current_class' ] ?></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-responsive table-bordered fee-voucher-table-dues">

                    <tbody>
                        <?php
                        $total_payable_amount = 0;
                        $total_payable_amount_after_deadline = 0;
                        ?>

                        <?php
                        if ( !empty( $fee_voucher_details[ 'admission_fee' ] ) ):
                            $total_payable_amount += intval( $fee_voucher_details[ 'admission_fee' ] );
                            $total_payable_amount_after_deadline += intval( $fee_voucher_details[ 'admission_fee' ] );
                            ?>

                            <tr>
                                <td>Admission fee</td>
                                <td><?= $fee_voucher_details[ 'admission_fee' ] ?></td>
                            </tr>

                        <?php endif; ?>

                        <?php
                        if ( !empty( $fee_voucher_details[ 'school_fee' ] ) ):
                            $total_payable_amount += intval( $fee_voucher_details[ 'school_fee' ] );
                            ?>
                            <tr>
                                <td>School fee</td>
                                <td><?= $fee_voucher_details[ 'school_fee' ] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php
                        if ( !empty( $fee_voucher_details[ 'examination_fee' ] ) ):
                            $total_payable_amount += intval( $fee_voucher_details[ 'examination_fee' ] );
                            $total_payable_amount_after_deadline += intval( $fee_voucher_details[ 'examination_fee' ] );
                            ?>
                            <tr>
                                <td>Examination fee</td>
                                <td><?= $fee_voucher_details[ 'examination_fee' ] ?></td>
                            </tr>
                        <?php endif; ?>


                        <?php
                        if ( !empty( $fee_voucher_details[ 'computer_fee' ] ) ):
                            $total_payable_amount += intval( $fee_voucher_details[ 'computer_fee' ] );
                            $total_payable_amount_after_deadline += intval( $fee_voucher_details[ 'computer_fee' ] );
                            ?>
                            <tr>
                                <td>Computer fee</td>
                                <td><?= $fee_voucher_details[ 'computer_fee' ] ?></td>
                            </tr>
                        <?php endif; ?>


                        <tr>
                            <td class="text-bold">Total payable amount <small style="font-weight: normal;">(Within due date)</small></td>
                            <td class="text-bold"><?= $total_payable_amount ?></td>
                        </tr>

                        <tr>
                            <td class="text-bold">Payable after due date</td>
                            <td class="text-bold"><?= $total_payable_amount_after_deadline + intval( $fee_voucher_details[ 'payable_after_deadline_1' ] ) ?></td>
                        </tr>


                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>


<?php $this->load->view( 'templates/blank_page_footer' ) ?>