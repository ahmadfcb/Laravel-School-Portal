<?php $this->load->view('templates/blank_page_header') ?>



<div class="container">
    
    <div class="leave-certificate">
        <div class="row leave-certificate-head">
            <div class="col-sm-6">Ref:______________________</div>
            
            <div class="col-sm-6 text-right">Date: <?= date("d-M-Y", now()) ?></div>
        </div>
        
        <h1 class="leave-certificate-heading">School leaving certificate</h1>
        
        <div>
            <table class="table table-bordered leave-certificate-table">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td><?= $student_details['first_name'] . ' ' . $student_details['last_name'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Father's Name</th>
                        <td><?= $student_details['father_name'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Date of  Birth (in Figures)</th>
                        <td><?= $student_details['dob'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Date of Birth (in Words)</th>
                        <td><?= $student_details['dob_word'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>PIN</th>
                        <td><?= $student_details['registration_number'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Date of joining school</th>
                        <td><?= $leave_certificate['admission_date'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Class when joined school</th>
                        <td><?= $student_details['admission_class'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Date of leaving school</th>
                        <td><?= $leave_certificate['leaving_date'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Class when left school</th>
                        <td><?= $student_details['current_class'] ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Behaviour</th>
                        <td><?= $leave_certificate['conduct'] ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

        </div>
        
        <div class="leave-certificate-remarks">
            Remarks:
        </div>
        
        <div class="leave-certificate-footer">
            <div class="row">
                <div class="col-sm-6">Office Stamp</div>
                
                <div class="col-sm-6 text-right">Principal</div>
            </div>
        </div>
        
    </div>
    
</div>



<?php $this->load->view('templates/blank_page_footer') ?>