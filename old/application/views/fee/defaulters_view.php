<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>



<?php
if ( $defaulters === false ) {
    echo "<h3 class='text-center'>No defaulters found!</h3>";
} else {
    ?>

    <div style="margin-bottom: 20px;">
        <form action="<?= current_url() ?>" class="form-inline" method="get">
            <div class="form-group">
                <label>Branch</label>

                <select name="school_branch" id="branch_DropDown" class="form-control">
                    <option value="" <?= set_select( 'school_branch', '', TRUE ) ?> >--Select--</option>
                    <option value="KG" <?= set_select( 'school_branch', 'KG' ) ?> >KG</option>
                    <option value="Junior" <?= set_select( 'school_branch', 'Junior' ) ?> >Junior</option>
                    <option value="Girls High" <?= set_select( 'school_branch', 'Girls High' ) ?> >Girls High</option>
                    <option value="Boys High" <?= set_select( 'school_branch', 'Boys High' ) ?> >Boys High</option>
                </select>
            </div>

            <div class="form-group">
                <label>Class</label>
                <select name="current_class" class="form-control">
                    <option value="" <?= set_select( 'current_class', '', TRUE ) ?> >--Select--</option>
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
                    <option value="" <?= set_select( 'section', '', TRUE ) ?> >--Select--</option>
                    <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                    <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                    <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                    <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                    <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Reg#</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Tuition fee</th>
                    <th>Arears</th>
                    <th>Exam fee arears</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ( $defaulters as $def ):
                    ?>
                    <tr>
                        <td><?= $def['registration_number'] ?></td>
                        <td>
                            <a href="<?= site_url( 'admin-dashboard/view_student' ) . '?stdid=' . $def['student_registration_id'] . '&redirect=' . urlencode( $redirect_url ) ?>"><?= $def['first_name'] . ' ' . $def['last_name'] ?></a>
                        </td>
                        <td><?= $def['current_class'] ?></td>
                        <td><?= $def['monthly_fee_detail_amount'] ?></td>
                        <td><?= $def['arears'] ?></td>
                        <td><?= $def['exam_fee_arears'] ?></td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>




<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>
