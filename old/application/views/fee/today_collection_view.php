<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<div class="table-responsive">

    <?php
    if ( $today_collection === false ):
        echo "<p>No collection has been made today!</p>";
    else:

        ?>
        <table class="table table-bordered">
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
                    <th>Total fee</th>
                    <th>Total paid</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ( $today_collection as $tcol ):
                    ?>
                    <td><?= date("d/m/Y H:i:s", strtotime($tcol['fp_payment_datetime'])) ?></td>
                    <td><?= $tcol['fp_admission_fee'] ?></td>
                    <td><?= $tcol['fp_registration_fee'] ?></td>
                    <td><?= $tcol['fp_tuition_fee'] ?></td>
                    <td><?= $tcol['fp_exam_fee'] ?></td>
                    <td><?= $tcol['fp_computer_fee'] ?></td>
                    <td><?= $tcol['fp_fine'] ?></td>
                    <td><?= $tcol['fp_other1'] ?></td>
                    <td><?= $tcol['fp_other2'] ?></td>
                    <td><?= $tcol['fp_other3'] ?></td>
                    <td><?= $tcol['fp_payable_within_due_date'] ?></td>
                    <td><?= $tcol['fp_payable_after_due_date'] ?></td>
                    <td><?= $tcol['fp_remission'] ?></td>
                    <td><?= $tcol['fp_total_fee'] ?></td>
                    <td><?= $tcol['fp_paid_fee'] ?></td>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
        <?php

    endif;
    ?>

</div>

<div class="text-right">
    <h3>Grand total: Rs. <?= $today_collection_total ?></h3>
</div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>
