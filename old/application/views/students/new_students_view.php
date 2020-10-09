<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>


<div>
    <form action="<?= current_url() ?>" method="get" id="cust_form1" class="form-inline text-center">
        <div class="form-group">
            <label>Branch</label>
            <select name="branch" id="branch_DropDown" class="form-control">
                <option value="" <?= set_select( 'branch', '', TRUE ) ?> ></option>
                <option value="KG" <?= set_select( 'branch', 'KG' ) ?> >KG</option>
                <option value="Junior" <?= set_select( 'branch', 'Junior' ) ?> >Junior</option>
                <option value="Girls High" <?= set_select( 'branch', 'Girls High' ) ?> >Girls High</option>
                <option value="Boys High" <?= set_select( 'branch', 'Boys High' ) ?> >Boys High</option>
            </select>
        </div>

        <div class="form-group">
            <label>Class</label>
            <select name="class" class="form-control">
                <option value="" <?= set_select( 'class', '', TRUE ) ?> ></option>
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
            <select name="section" class="form-control">
                <option value="" <?= set_select( 'section', '', TRUE ) ?> ></option>
                <option value="A" <?= set_select( 'section', 'A' ) ?> >A</option>
                <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date from</label>
            <input type="date" class="form-control" name="date_from" value="<?= set_value( 'date_from' ) ?>">
        </div>

        <div class="form-group">
            <label>Date to</label>
            <input type="date" class="form-control" name="date_to" value="<?= set_value( 'date_to' ) ?>">
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="withdrawn" value="1" <?= set_checkbox( 'withdrawn', '1' ) ?>> Widthdrawn
                </label>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

<div>
    <?php if ( empty( $students ) ): ?>
        <p class="text-center text-danger">No new student for current search</p>
    <?php else: ?>
        <div style="margin: 20px 0;">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Total: <?= ( $total->male + $total->female ) ?></td>
                        <td>Male: <?= $total->male ?></td>
                        <td>Female: <?= $total->female ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>PIN</th>
                        <th>Name</th>
                        <th>Father's name</th>
                        <th>Branch</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Picture</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $students as $student ): ?>
                        <tr>
                            <td><?= $student['registration_number'] ?></td>
                            <td><?= $student['first_name'] . ' ' . $student['last_name'] ?></td>
                            <td><?= $student['father_name'] ?></td>
                            <td><?= $student['school_branch'] ?></td>
                            <td><?= $student['current_class'] ?></td>
                            <td><?= $student['section'] ?></td>
                            <td>
                                <img src="<?= base_url( $student['profile_pic'] ) ?>" alt="" style="max-height: 60px;">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>
