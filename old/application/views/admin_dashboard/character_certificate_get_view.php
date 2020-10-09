<?php $this->load->view('templates/blank_page_header') ?>

<div class="character-certificate-container">
    <div class="container">
        
        <div class="text-center hidden-print" style="margin: 15px;"><button type="button" class="btn btn-primary" onclick="window.print();">Print</button></div>
        
        <div class="character-certificate-inner-container">

            <div class="character-certificate-header">
                <div class="row">

                    <div class="col-xs-12 text-center">
                        <div style="margin: 10px 0;">
                            <img class="center-block" src="<?= base_url('img/prime-foundation-logo.png') ?>" width="150">
                        </div>
                        <h1 class="character-certificate-school-name">PRIME FOUNDATION SCHOOL</h1>
                        <h3 class="character-certificate-title">CHARACTER CERTIFICATE</h3>
                    </div>

                </div>
            </div>

            <div class="character-certificate-body">

                <div class="row">
                    <div class="col-sm-6">PIN: <?= $student_details['registration_number'] ?></div>
                    <div class="col-sm-6 text-right">Date: <?= date("d-M-Y", now()) ?></div>

                    <div style="margin-top: 50px;" class="col-xs-12"></div>

                    <div class="col-xs-12">
                        
                        <p>This is to certify that <span class="underline bold"><?= $student_details['first_name'] . ' ' . $student_details['last_name'] ?></span> S/O <span class="underline bold"><?= $student_details['father_name'] ?></span> has been a bonafide student of this school of class <span class="underline bold"><?= $student_details['current_class'] ?></span>. His date of birth according to school record is <span class="underline bold"><?= $student_details['dob'] ?> (<?= $student_details['dob_word'] ?>)</span></p>
                        <p>He has been a <?= $leave_certificate['conduct'] ?> student. I wish him success in life.</p>

                    </div>

                    <div style="margin-top: 15px;" class="col-xs-12"></div>
                    
                    <div class="bold col-xs-12">Remarks:</div>
                    
                    <div style="margin-top: 70px;" class="col-xs-12"></div>

                    <div class="col-sm-6">Dated: <?= mdate('%D, %j%S of %M, %Y') ?></div>
                    <div class="col-sm-6 text-right">Signature ___________________</div>
                </div>

            </div>

        </div>
    </div>
</div>


<?php $this->load->view('templates/blank_page_footer') ?>