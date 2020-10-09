<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= ( empty( $title ) ? "Prime Foundation School" : "{$title} | Prime Foundation School" ) ?></title>
        <meta name="description" content="Prime Foundation School System">
        <meta name="keywords" content="School, Prime, Kids, Teachers">
        <link rel="shortcut icon" href="<?= base_url('img/favicon.png') ?>">

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i|Candal|Alegreya+Sans">
        <link rel="stylesheet" type="text/css" href="<?= base_url( 'css/font-awesome.min.css' ) ?>">
        <!--<link rel="stylesheet" type="text/css" href="<?= base_url( "css/bootstrap.min.css" ) ?>">-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url('css/nivo-slider.css') ?>">
        <link rel="stylesheet" href="<?= base_url('css/default/default.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url( "css/imagehover.min.css" ) ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url( "css/style.css" ) ?>">
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        
        <!--Navigation bar-->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?= site_url() ?>">Prime <span>Foundation</span></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">

                        <li><a href="<?= (current_url() == base_url() || current_url() == site_url() ? "" : site_url()) ?>#top">Home</a></li>
                        <li><a href="<?= (current_url() == base_url() || current_url() == site_url() ? "" : site_url()) ?>#institute-overview">Institue overview</a></li>
                        <li><a href="<?= (current_url() == base_url() || current_url() == site_url() ? "" : site_url()) ?>#testimonial">Chairman message</a></li>
                        <li><a href="<?= (current_url() == base_url() || current_url() == site_url() ? "" : site_url()) ?>#contact">Contact us</a></li>
                        <li><a href="<?= (current_url() == base_url() || current_url() == site_url() ? "" : site_url()) ?>#Map">How to reach us</a></li>
                        <li><a href="<?= site_url('home/events') ?>">Events</a></li>
                        <li><a href="<?= site_url('home/news') ?>">News</a></li>
                        <?php
                        if ( $this->account_library->logged_in() ) {
                            ?>
                            <li><a href="<?= site_url( "admin-dashboard" ) ?>">Admin panel</a></li>
                            <li><a href="<?= site_url( "admin-account/sign-out" ) ?>">Sign out</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="#" data-target="#login" data-toggle="modal">Sign in</a></li>
                            <?php
                        }
                        ?>

                        <!--<li class="btn-trial"><a href="#footer">Footer</a></li>-->
                    </ul>
                </div>
            </div>
        </nav>
        <!--/ Navigation bar-->
        <!--Modal box-->
        <div class="modal fade" id="login" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content no 1-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center form-title">Login</h4>
                    </div>
                    <div class="modal-body padtrbl">

                        <div class="login-box-body">
                            <p class="login-box-msg">Sign in to start your session</p>
                            <div class="form-group">
                                <form name="" id="loginForm" action="<?= site_url( 'admin-account/sign-in-process' ) ?>" method="post">
                                    <div class="alert alert-danger" id='loginError' style="display: none;"></div>
                                    <div class="form-group has-feedback"> <!----- username -------------->
                                        <input class="form-control" name="username" placeholder="Username"  id="username" type="text" autocomplete="off" /> 
                                        <span style="display:none;font-weight:bold; position:absolute;color: red;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginid"></span><!---Alredy exists  ! -->
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                                    <div class="form-group has-feedback"><!----- password -------------->
                                        <input class="form-control" name="password" placeholder="Password" id="password" type="password" autocomplete="off" />
                                        <span style="display:none;font-weight:bold; position:absolute;color: grey;position: absolute;padding:4px;font-size: 11px;background-color:rgba(128, 128, 128, 0.26);z-index: 17;  right: 27px; top: 5px;" id="span_loginpsw"></span><!---Alredy exists  ! -->
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                    <div class="row">

                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-blue btn-block btn-flat">Sign In</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--/ Modal box-->
        
        <!--Delete student confirmation modal box-->
        <div class="modal fade" id="delete_modal" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content no 1-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center form-title">Do you really want to delete it?</h4>
                        
                        <div class="form-group" style="margin-bottom: 0; margin-top: 10px;">
                            <label>Student's registration no.</label>
                            <input type="text" name="modal_reg_number" class="form-control" placeholder="Student's registration number confirmation">
                        </div>
                    </div>
                    <div class="modal-body padtrbl">

                        <div class="row">
                            
                            <div class="col-sm-6"><a class="btn btn-block btn-danger yes-button" href="#">Yes</a></div>
                            <div class="col-sm-6"><a class="btn btn-block btn-primary" data-dismiss="modal" href="#">No</a></div>
                            
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
        <!--/Delete confirmation modal box-->
        
        <!-- #generalDeleteModal -->
        <div id="generalDeleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-sm">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">You really want to delete this?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6"><a href="#" class="btn btn-danger btn-block btn-del-yes">Yes</a></div>
                            
                            <div class="col-sm-6"><button type="button" class="btn btn-primary btn-block" data-dismiss="modal">No</button></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /#generalDeleteModal -->
        
        <div id="top"></div>