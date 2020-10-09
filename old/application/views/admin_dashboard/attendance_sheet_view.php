<?php $this->load->view( 'templates/blank_page_header' ) ?>

<?php
$number_of_days = 26;
?>

<div class="attendance-sheet">

    <button class="center-block hidden-print btn btn-primary btn_print" onclick="window.print();">Print</button>

    <div class="attendance-sheet-head">
        <div class="attendance-sheet-class">
            <b>Class:</b> <?= $class ?>
            <br>
            <b>Section:</b> <?= $section ?>
        </div>
    </div>

    <div class="attendance-sheet-body">
        <table class="table table-bordered table-striped attendance-sheet-table">
            <thead>
                <tr>
                    <th colspan="3" style="border: none;"></th>
                    <th colspan="<?= $number_of_days ?>" class="text-center">Date</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <th>Pin</th>
                    <th>Sr</th>
                    <th>Name</th>
                    <?php
                    for ( $i = 0; $i < $number_of_days; $i++ ) {
                        echo '<td>' . ($i + 1) . '</td>';
                    }
                    ?>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $student_details as $key => $std ): ?>

                    <tr>
                        <td><?= $std[ 'registration_number' ] ?></td>
                        <td><?= $key + 1 ?></td>
                        <td><?= $std[ 'first_name' ] . ' ' . $std[ 'last_name' ] ?></td>
                        <?php
                        for ( $i = 0; $i < $number_of_days; $i++ ) {
                            echo '<td></td>';
                        }
                        ?>
                        <td></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>



<?php $this->load->view( 'templates/blank_page_footer' ) ?>