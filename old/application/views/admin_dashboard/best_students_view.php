<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


<?php if ( $best_students === false ): ?>
    <h3 style="opacity: 0.8;" class="text-center">You haven't added any best student yet! Type information of the 3 in the forms provided below.</h3>
<?php else: ?>
    <div class="table-responsive">

        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Reg#</th>
                    <th>Roll#</th>
                    <th>Father Name</th>
                    <th>Branch</th>
                    <th>Class</th>
                    <th>Section</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $best_students as $std ): ?>
                    <tr>
                        <td><?= (!empty( $std[ 'student_name' ] ) ? $std[ 'student_name' ] : "N/A") ?></td>
                        <td><?= (!empty( $std[ 'student_registration_no' ] ) ? $std[ 'student_registration_no' ] : "N/A") ?></td>
                        <td><?= (!empty( $std[ 'roll_no' ] ) ? $std[ 'roll_no' ] : "N/A") ?></td>
                        <td><?= (!empty( $std[ 'father_name' ] ) ? $std[ 'father_name' ] : "N/A") ?></td>
                        <td><?= (!empty( $std[ 'branch' ] ) ? $std[ 'branch' ] : "N/A") ?></td>
                        <td><?= (!empty( $std[ 'class' ] ) ? $std[ 'class' ] : "N/A") ?></td>
                        <td><?= (!empty( $std[ 'section' ] ) ? $std[ 'section' ] : "N/A") ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <p class="help-block">Add new student details from below form to delete current best students and add new ones.</p>

    </div>
<?php endif; ?>


<div class="row">
    
    <form action="<?= site_url( 'admin-dashboard/best-students-process' ) ?>" method="post">

        <?php for ( $i = 0; $i < 3; $i++ ): ?>

            <div class="col-sm-6 <?= ($i + 1 == 3) ? "col-sm-offset-3" : ""; ?>">

                <h2 class="text-center">Student <?= $i + 1 ?></h2>

                <div class="form-group">
                    <label>Student Name</label>
                    <input class="form-control" type="text" name="name[]" value="<?= set_value( 'name[' . $i . ']' ) ?>" required="">
                </div>

                <div class="form-group">
                    <label>Student Registration Number</label>
                    <input class="form-control" type="number" name="registration_no[]" value="<?= set_value( 'registration_no[' . $i . ']' ) ?>" required="">
                </div>

                <div class="form-group">
                    <label>Roll Number</label>
                    <input class="form-control" type="number" name="roll_number[]" value="<?= set_value( 'roll_number[' . $i . ']' ) ?>">
                </div>

                <div class="form-group">
                    <label>Father's Name</label>
                    <input class="form-control" type="text" name="father_name[]" value="<?= set_value( 'father_name[' . $i . ']' ) ?>">
                </div>

                <div class="form-group">
                    <label>Branch</label>

                    <select name="school_branch[]" id="branch_DropDown" class="form-control">
                        <option value="" <?= set_select( 'school_branch[' . $i . ']', '', TRUE ) ?> >--Select--</option>
                        <option value="KG" <?= set_select( 'school_branch[' . $i . ']', 'KG' ) ?> >KG</option>
                        <option value="Junior" <?= set_select( 'school_branch[' . $i . ']', 'Junior' ) ?> >Junior</option>
                        <option value="Girls High" <?= set_select( 'school_branch[' . $i . ']', 'Girls High' ) ?> >Girls High</option>
                        <option value="Boys High" <?= set_select( 'school_branch[' . $i . ']', 'Boys High' ) ?> >Boys High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Current Class</label>
                    <p class="help-block">Current class of the student</p>
                    <select name="current_class[]" class="form-control">
                        <option value="" <?= set_select( 'current_class[' . $i . ']', '', TRUE ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'current_class[' . $i . ']', 'Toddlers' ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'current_class[' . $i . ']', 'LKG' ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'current_class[' . $i . ']', 'UKG' ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'current_class[' . $i . ']', '1st' ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'current_class[' . $i . ']', '2nd' ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'current_class[' . $i . ']', '3rd' ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'current_class[' . $i . ']', '4th' ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'current_class[' . $i . ']', '5th' ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'current_class[' . $i . ']', '6th' ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'current_class[' . $i . ']', '7th' ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'current_class[' . $i . ']', '8th' ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'current_class[' . $i . ']', '9th' ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'current_class[' . $i . ']', '10th' ) ?> >10th</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Section</label>
                    <select name="section[]" class="form-control">
                        <option value="" <?= set_select( 'section[' . $i . ']', '', TRUE ) ?> >--Select--</option>
                        <option value="A" <?= set_select( 'section[' . $i . ']', 'A' ) ?> >A</option>
                        <option value="B" <?= set_select( 'section[' . $i . ']', 'B' ) ?> >B</option>
                        <option value="C" <?= set_select( 'section[' . $i . ']', 'C' ) ?> >C</option>
                        <option value="D" <?= set_select( 'section[' . $i . ']', 'D' ) ?> >D</option>
                        <option value="E" <?= set_select( 'section[' . $i . ']', 'E' ) ?> >E</option>
                    </select>
                </div>

            </div>

        <?php endfor; ?>

        <div class="clearfix"></div>

        <div class="form-group text-center">
            <button class="btn btn-primary" type="submit">Save and update</button>
        </div>

    </form>
</div>




<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>