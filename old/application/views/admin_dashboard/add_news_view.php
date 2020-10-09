<?php $this->load->view("admin_dashboard/templates/admin_panel_header") ?>

<?php
$this->general_library->show_error_or_msg();
echo validation_errors('<div class="alert alert-danger">', '</div>');
?>


<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        <form enctype="multipart/form-data" action="<?= site_url('admin_dashboard/add_news_process') ?>" method="post">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="news_title" class="form-control form" placeholder="Title for news" value="">
            </div>

            <div class="form-group">
                <label>Picture</label>
                
                <input type="file" name="pic" class="form show-image-preview">
                
                <div class="text-center">
                    <img class="image-preview img-responsive" src="">
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" rows="5" placeholder="Description"></textarea>
            </div>
            
            <div class="form-group">
                <label>News/Event</label>
                <select name="post_type" class="form-control">
                    <option value="event" <?= set_select( 'post_type', 'event') ?>>Event</option>
                    <option value="news" <?= set_select( 'post_type', 'news', true) ?>>News</option>
                </select>
            </div>

            <div class="col-xs-12 text-center">
                <!-- Button -->
                <button type="submit" class="btn btn-primary">ADD NEWS/EVENT</button>
            </div>

        </form>
    </div>
</div>


<?php $this->load->view("admin_dashboard/templates/admin_panel_footer") ?>