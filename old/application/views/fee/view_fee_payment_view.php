<?php $this->load->view( "templates/blank_page_header" ) ?>



<div class="container">
    <div class="hidden-print">
        <a href="<?= $redirect_url ?>" class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
        <button type="button" class="btn btn-primary" style="margin: 20px;" onclick="window.print();">Print</button>
    </div>

    <table class="table" style="min-width: 300px; max-width: 500px;">
        <tbody>
            <tr>
                <td>Receipt no#</td>
                <td><?= $fee_payment_details['fp_id'] ?></td>
            </tr>

            <tr>
                <td>Due date</td>
                <td><?= mdate('10/%m/%Y', strtotime($fee_payment_details['fp_payment_datetime'])) ?></td>
            </tr>

            <tr>
                <td>Payment date</td>
                <td><?= mdate('%d/%m/%Y', strtotime($fee_payment_details['fp_payment_datetime'])) ?></td>
            </tr>

            <tr>
                <td>Name</td>
                <td><?= $fee_payment_details['first_name'] . ' ' . $fee_payment_details['last_name'] ?></td>
            </tr>

            <tr>
                <td>Reg#</td>
                <td><?= $fee_payment_details['registration_number'] ?></td>
            </tr>

            <tr>
                <td>Admission Fee</td>
                <td><?= $fee_payment_details['fp_admission_fee'] ?></td>
            </tr>

            <tr>
                <td>Registration Fee</td>
                <td><?= $fee_payment_details['fp_registration_fee'] ?></td>
            </tr>

            <tr>
                <td>Tuition Fee</td>
                <td><?= $fee_payment_details['fp_tuition_fee'] ?></td>
            </tr>

            <tr>
                <td>Exam Fee</td>
                <td><?= $fee_payment_details['fp_exam_fee'] ?></td>
            </tr>

            <tr>
                <td>Computer Fee</td>
                <td><?= $fee_payment_details['fp_computer_fee'] ?></td>
            </tr>

            <tr>
                <td>Fine</td>
                <td><?= $fee_payment_details['fp_fine'] ?></td>
            </tr>

            <tr>
                <td>Other 1</td>
                <td><?= $fee_payment_details['fp_other1'] ?></td>
            </tr>

            <tr>
                <td>Other 2</td>
                <td><?= $fee_payment_details['fp_other2'] ?></td>
            </tr>

            <tr>
                <td>Other 3</td>
                <td><?= $fee_payment_details['fp_other3'] ?></td>
            </tr>

            <tr>
                <td <?= ($fee_payment_details['fp_payable_within_due_date'] == $fee_payment_details['fp_total_fee'] ? "style='font-weight: bold;'" : "" ) ?>>Payable within due date</td>
                <td <?= ($fee_payment_details['fp_payable_within_due_date'] == $fee_payment_details['fp_total_fee'] ? "style='font-weight: bold;'" : "" ) ?>><?= $fee_payment_details['fp_payable_within_due_date'] ?></td>
            </tr>

            <tr>
                <td <?= ($fee_payment_details['fp_payable_after_due_date'] == $fee_payment_details['fp_total_fee'] ? "style='font-weight: bold;'" : "" ) ?>>Payable after due date</td>
                <td <?= ($fee_payment_details['fp_payable_after_due_date'] == $fee_payment_details['fp_total_fee'] ? "style='font-weight: bold;'" : "" ) ?>><?= $fee_payment_details['fp_payable_after_due_date'] ?></td>
            </tr>

            <tr>
                <td>Sub total</td>
                <td><?= $fee_payment_details['fp_total_fee'] ?></td>
            </tr>

            <tr>
                <td>Remission</td>
                <td><?= $fee_payment_details['fp_remission'] ?></td>
            </tr>

            <tr>
                <td style="font-weight: bold;">Grand total</td>
                <td style="font-weight: bold;"><?= $fee_payment_details['fp_paid_fee'] ?></td>
            </tr>
        </tbody>
    </table>
</div>




<?php $this->load->view( "templates/blank_page_footer" ) ?>
