<?php $this->load->view( 'templates/blank_page_header' ) ?>

<button type="button" class="hidden-print btn btn-primary" style="margin: 15px;" onclick="window.print();">Print</button>

<div class="clearfix"></div>

<?php foreach ( $student_details as $std ): ?>

    <div class="card-container">
        <div class="inner-padding" style="display: inline-block;">

            <h3>Prime Foundation School System</h3>

            <div class="card-left">
                <img src="<?= base_url( $std[ 'profile_pic' ] ) ?>" class="img-responsive" width="120" height="120">
            </div>
            <div class="card-right">
                <div class=""><b>Name</b>: <?= $std[ 'first_name' ] . " " . $std[ 'last_name' ] ?></div>
                <div class=""><b>Father's name</b>: <?= $std[ 'father_name' ] ?></div>
                <div class=""><b>CNIC</b>: <?= $std[ 'cnic' ] ?></div>
                <div class=""><b>Registration No</b>: <?= $std[ 'registration_number' ] ?></div>
                <div class=""><b>Class</b>: <?= $std[ 'current_class' ] ?></div>
                <div class=""><b>Section</b>: <?= $std[ 'section' ] ?></div>
            </div>

            <div class="clearfix"></div>

            <div class="card-footer">
                <div class="card-footer-left">Print date: <?= date("d-M-Y", now()) ?></div>
                <div class="card-footer-right text-bold text-right">Principal's sig. : ________________</div>
            </div>

        </div>
        
    </div>

<?php endforeach; ?>



<?php $this->load->view( 'templates/blank_page_footer' ) ?>