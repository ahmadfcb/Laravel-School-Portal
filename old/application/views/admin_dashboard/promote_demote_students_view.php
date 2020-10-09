<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>


    <p class="help-block">Select Branch, Class and Section to get list of students.</p>
    <div class="row">
        <div class="col-sm-12">

            <form action="" method="get" class="form-inline">
                <div class="form-group">
                    <label>Branch</label>
                    <select name="branch" id="branch_DropDown" class="form-control" required="">
                        <option value="" <?= set_select( 'branch', '', TRUE ) ?> >--Select--</option>
                        <option value="KG" <?= set_select( 'branch', 'KG' ) ?> >KG</option>
                        <option value="Junior" <?= set_select( 'branch', 'Junior' ) ?> >Junior</option>
                        <option value="Girls High" <?= set_select( 'branch', 'Girls High' ) ?> >Girls High</option>
                        <option value="Boys High" <?= set_select( 'branch', 'Boys High' ) ?> >Boys High</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Class</label>
                    <select name="class" class="form-control" required="">
                        <option value="" <?= set_select( 'class', '', TRUE ) ?> >--Select--</option>
                        <option value="Toddlers" <?= set_select( 'class', 'Toddlers' ) ?> >Toddlers</option>
                        <option value="LKG" <?= set_select( 'class', 'LKG' ) ?> >LKG</option>
                        <option value="UKG" <?= set_select( 'class', 'UKG' ) ?> >UKG</option>
                        <option value="1st" <?= set_select( 'class', '1st' ) ?> >1st</option>
                        <option value="2nd" <?= set_select( 'class', '2nd' ) ?> >2nd</option>
                        <option value="3rd" <?= set_select( 'class', '3rd' ) ?> >3rd</option>
                        <option value="4th" <?= set_select( 'class', '4th' ) ?> >4th</option>
                        <option value="5th" <?= set_select( 'class', '5th' ) ?> >5th</option>
                        <option value="6th" <?= set_select( 'class', '6th' ) ?> >6th</option>
                        <option value="7th" <?= set_select( 'class', '7th' ) ?> >7th</option>
                        <option value="8th" <?= set_select( 'class', '8th' ) ?> >8th</option>
                        <option value="9th" <?= set_select( 'class', '9th' ) ?> >9th</option>
                        <option value="10th" <?= set_select( 'class', '10th' ) ?> >10th</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Section</label>
                    <select name="section" class="form-control" required="">
                        <option value="" <?= set_select( 'section', '', TRUE ) ?> >--Select--</option>
                        <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                        <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                        <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                        <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                        <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Search</button>
            </form>

        </div>
    </div>

<?php
if ( $student_details !== null ):
    if ( $student_details === false ):
        echo "<h3>No students were found.</h3>";
    else:
        ?>
        <h4>Available students</h4>
        <form action="<?= site_url( 'admin-dashboard/promote-demote-students-process' ) ?>" method="post" class="form-inline">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="select_all_checkbox" class="select_all_checkbox" data-target=".select_all_checkbox_inputs">
                            </th>
                            <th>Reg#</th>
                            <th>Name</th>
                            <th>Father/Guardian name</th>
                            <th>School branch</th>
                            <th>Current class</th>
                            <th>Section</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ( $student_details as $std ):
                            ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="select_all_checkbox_inputs" name="std_id[]" value="<?= $std['student_registration_id'] ?>">
                                </td>
                                <td><?= $std['registration_number'] ?></td>
                                <td><?= $std['first_name'] . ' ' . $std['last_name'] ?></td>
                                <td><?= $std['father_name'] ?></td>
                                <td><?= $std['school_branch'] ?></td>
                                <td><?= $std['current_class'] ?></td>
                                <td><?= $std['section'] ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>


            <h4>Promote / Demote to</h4>
            <p class="help-block">Select branch, class and section to which you want to Promote/Demote the selected students</p>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Branch</label>
                        <select name="branch" id="branch_DropDown" class="form-control" required="">
                            <option value="">--Select--</option>
                            <option value="KG">KG</option>
                            <option value="Junior">Junior</option>
                            <option value="Girls High">Girls High</option>
                            <option value="Boys High">Boys High</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Class</label>
                        <select name="class" class="form-control" required="">
                            <option value="">--Select--</option>
                            <option value="Toddlers">Toddlers</option>
                            <option value="LKG">LKG</option>
                            <option value="UKG">UKG</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                            <option value="5th">5th</option>
                            <option value="6th">6th</option>
                            <option value="7th">7th</option>
                            <option value="8th">8th</option>
                            <option value="9th">9th</option>
                            <option value="10th">10th</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Section</label>
                        <select name="section" class="form-control" required="">
                            <option value="">--Select--</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>

                </div>
            </div>

            <input type="hidden" name="redirect" value="<?= current_url() . "?" . $_SERVER['QUERY_STRING'] ?>">

            <button type="submit" class="btn btn-primary center-block">Promote / Demote</button>
        </form>
        <?php
    endif;
endif;
?>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>