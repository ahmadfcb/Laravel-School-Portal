<?php $this->load->view( "admin_dashboard/templates/admin_panel_header" ) ?>


<div class="row">
    <div class="col-sm-6 col-sm-offset-1">
        <form action="<?= site_url( 'admin-dashboard/general-sms-send' ) ?>" method="post">

            <div class="form-group">
                <label>SMS templates</label>
                <div>
                    <?php
                    if ( $sms_templates === false ):
                        echo '<p>No SMS templates found!</p>';
                    else:
                        ?>
                        <ul class="list-unstyled">
                            <?php
                            foreach ( $sms_templates as $temp ):
                                ?>

                                <li><a href="#" class="sms-template" title="<?= $temp[ 'sms_template_body' ] ?>"><?= substr( $temp[ 'sms_template_body' ], 0, 50 ) . ( strlen( $temp[ 'sms_template_body' ] ) > 50 ? "..." : "" ) ?></a></li>

                                <?php
                            endforeach;
                            ?>
                        </ul>
                    <?php
                    endif;
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea name="msg" id="sms_msg" class="form-control" rows="3" placeholder="Type your SMS here"></textarea>
            </div>

            <?php foreach ( $reg_number as $rnmb ): ?>
                <input type="hidden" name="reg_number[]" value="<?= $rnmb ?>">
            <?php endforeach; ?>

            <div class="text-center">
                <button class="btn btn-primary" type="submit">Send SMS</button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript">
    jQuery(function($){
        $(".sms-template").click(function(e){
            e.preventDefault();
            
            var temp_text = $(this).attr('title');
            
            $("#sms_msg").text(temp_text);
        });
    });
</script>


<?php $this->load->view( "admin_dashboard/templates/admin_panel_footer" ) ?>