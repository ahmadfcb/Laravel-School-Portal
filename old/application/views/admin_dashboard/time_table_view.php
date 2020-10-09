<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>




<div class="row">

    <div class="col-sm-12">

        <form action="<?= site_url( 'admin-dashboard/time-table-process' ) ?>" method="POST" class="form-inline text-center">

            <div class="form-group">
                <label>Branch</label>

                <select name="branch" id="branch_DropDown" class="form-control" required="">
                    <option value="KG" <?= set_select( 'branch', 'KG', true ) ?> >KG</option>
                    <option value="Junior" <?= set_select( 'branch', 'Junior' ) ?> >Junior</option>
                    <option value="Girls High" <?= set_select( 'branch', 'Girls High' ) ?> >Girls High</option>
                    <option value="Boys High" <?= set_select( 'branch', 'Boys High' ) ?> >Boys High</option>
                </select>
            </div>

            <div class="form-group">
                <label>Class</label>
                <select name="class" class="form-control" required="">
                    <option value="Toddlers" <?= set_select( 'class', 'Toddlers', true ) ?> >Toddlers</option>
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
                    <option value="A" <?= set_select( 'section', 'A', true ) ?> >A</option>
                    <option value="B" <?= set_select( 'section', 'B' ) ?> >B</option>
                    <option value="C" <?= set_select( 'section', 'C' ) ?> >C</option>
                    <option value="D" <?= set_select( 'section', 'D' ) ?> >D</option>
                    <option value="E" <?= set_select( 'section', 'E' ) ?> >E</option>
                </select>
            </div>

            <div class="form-group">
                <label>Select Teacher</label>
                <select class="form-control" name="teacher_id" required="">
                    <?php if ( $teachers_details !== false ): ?>
                        <?php foreach ( $teachers_details as $tchr ): ?>
                            <option value="<?= $tchr[ 'teacher_id' ] ?>" <?= set_select( 'teacher_id', $tchr[ 'teacher_id' ] ) ?>><?= $tchr[ 'name' ] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Class start time</label>
                <input type="time" name="class_start_time" class="form-control" value="<?= set_value( 'class_start_time' ) ?>" placeholder="i.e. 09:00 am" required="">
            </div>

            <div class="form-group">
                <label>Class end time</label>
                <input type="time" name="class_end_time" class="form-control" value="<?= set_value( 'class_end_time' ) ?>" placeholder="i.e. 09:00 am" required="">
            </div>

            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control" value="<?= set_value( 'subject' ) ?>" placeholder="i.e. English">
            </div>

            <br>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Add entry in time table</button>
            </div>

        </form>

    </div>

    <div class="col-sm-12">

        <?php if ( $time_table === false ): ?>
            <h3 class="text-center">No time table items found</h3>
        <?php else: ?>

            <hr class="bottom-line">

            <h2>Existing entries</h2>

            <form action="<?= current_url() ?>" method="GET" class="form-inline">

                <div class="form-group">
                    <label>Filter by</label>
                    <select name="filter_by" class="form-control time_table_filter_by">
                        <option value="" <?= set_select( 'filter_by', '', true ) ?>>--Select--</option>
                        <option value="teacher" <?= set_select( 'filter_by', 'teacher' ) ?>>Teachers</option>
                        <option value="branch_class_section" <?= set_select( 'filter_by', 'branch_class_section' ) ?>>Branch, Class, Section</option>
                        <option value="time_range" <?= set_select( 'filter_by', 'time_range' ) ?>>Time range</option>
                    </select>
                </div>

                <div class="time_table_search_by search_by_teacher" style="display: none;">
                    <div class="form-group">
                        <label>Select Teacher</label>
                        <select class="form-control" name="teacher_id" required="">
                            <option value="" <?= set_select( 'teacher_id', '', true ) ?>>--Select--</option>
                            <?php if ( $teachers_details !== false ): ?>
                                <?php foreach ( $teachers_details as $tchr ): ?>
                                    <option value="<?= $tchr[ 'teacher_id' ] ?>" <?= set_select( 'teacher_id', $tchr[ 'teacher_id' ] ) ?>><?= $tchr[ 'name' ] ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="time_table_search_by search_by_branch_class_section" style="display: none;">

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
                        <label>Current Class</label>

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

                </div>

                <div class="time_table_search_by search_by_time_range" style="display: none;">
                    <div class="form-group">
                        <label>Time from</label>
                        <input type="time" class="form-control" name="time_start" value="<?= set_value( "time_start" ) ?>" placeholder="i.e. 11:00 am">
                    </div>

                    <div class="form-group">
                        <label>Time to</label>
                        <input type="time" class="form-control" name="time_end" value="<?= set_value( 'time_end' ) ?>" placeholder="i.e. 12:00 am">
                    </div>
                </div>

                <div class="form-group text-center">
                    <button class="btn btn-primary" type="submit">Filter</button>
                </div>

            </form>

            <div class="table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Teacher name</th>
                            <th>Class start time</th>
                            <th>Class end time</th>
                            <th>Branch</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ( $time_table as $tbl ): ?>

                            <tr>
                                <td><?= $tbl[ 'name' ] ?></td>
                                <td><?= date( 'h:i A', strtotime( $tbl[ 'class_start_time' ] ) ) ?></td>
                                <td><?= date( 'h:i A', strtotime( $tbl[ 'class_end_time' ] ) ) ?></td>
                                <td><?= $tbl[ 'branch' ] ?></td>
                                <td><?= $tbl[ 'class' ] ?></td>
                                <td><?= $tbl[ 'section' ] ?></td>
                                <td><?= $tbl[ 'subject' ] ?></td>
                                <td><a href="#" class="text-danger" data-url="<?= site_url( 'admin-dashboard/time-table-delete/' . $tbl[ 'id' ] ) . '?redirect=' . urlencode( $this->general_library->current_url() ) ?>" data-toggle="modal" data-target="#generalDeleteModal">Delete</a></td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        <?php endif; ?>

    </div>

</div>


<script type="text/javascript">

    jQuery( function ( $ ) {

        function show_search_by() {

            var value = $( '.time_table_filter_by' ).val(),
                    class_prefix = ".search_by_",
                    selector_class = class_prefix + value;

            $( '.time_table_search_by' ).hide();

            $( selector_class ).slideDown();

        }

        show_search_by();

        $( '.time_table_filter_by' ).change( function () {

            show_search_by();

        } );

    } );

</script>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>