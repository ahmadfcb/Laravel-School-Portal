<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors( '<div class="alert alert-danger">', '</div>' );
?>



<div class="row">
    <div class="col-sm-7">
        <h2>Templates</h2>
        <?php if ( $sms_templates === false ): ?>
            <h3>No templates are currently available!</h3>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Template Text</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $sms_templates as $temp ): ?>
                            <tr>
                                <td><?= nl2br( $temp[ 'sms_template_body' ] ) ?></td>
                                <td>
                                    <ul>
                                        <li><a href="#" class="text-danger" data-url="<?= site_url( 'admin-dashboard/sms-templates-delete/' . $temp[ 'sms_template_id' ] ) ?>" data-toggle="modal" data-target="#generalDeleteModal">Delete</a></li>
                                    </ul>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        <?php endif; ?>
    </div>

    <div class="col-sm-5">
        <h2>Add new template</h2>
        <form action="<?= site_url( 'admin-dashboard/sms-templates-process' ) ?>" method="post">
            <div class="form-group">
                <label>SMS template text</label>
                <textarea name="template_text" class="form-control" rows="3" placeholder="Type your template text here." required=""><?= set_value( 'template_text' ) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary center-block">Add Template</button>
        </form>
    </div>
</div>




<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>