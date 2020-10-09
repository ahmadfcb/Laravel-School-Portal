<?php $this->load->view( "templates/main_header_view" ) ?>


<!--Contact-->
<section id ="contact" class="section-padding">
    <div class="container">
        <div class="row">
            
            <div class="header-section text-center">
                <h2>Login</h2>
                <p>Sign in to start your session</p>
                <hr class="bottom-line">
            </div>
            <div id="sendmessage">Your message has been sent. Thank you!</div>
            <div id="errormessage"></div>
            <form action="<?= site_url('admin-account/sign-in-process') ?>" method="post" role="form" class="contactForm">
                <div class="col-md-6 col-sm-6 col-sm-offset-3 col-md-offset-3 col-xs-12 left">
                    <?php $this->general_library->show_error_or_msg() ?>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control form" id="username" placeholder="Username" />
                        <div class="validation"></div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Your password" />
                        <div class="validation"></div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                    <!-- Button -->
                    <button type="submit" id="submit" name="submit" class="form contact-form-button light-form-button oswald light">Sign In</button>
                </div>
            </form>

        </div>
    </div>
</section>
<!--/ Contact-->




<?php $this->load->view( "templates/main_footer_view" ) ?>