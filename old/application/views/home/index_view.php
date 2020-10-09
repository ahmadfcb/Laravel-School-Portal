<?php $this->load->view( "templates/main_header_view" ) ?>

<?php $this->load->view( "templates/banner_view" ) ?>

<?php $this->general_library->show_error_or_msg() ?>

<!--Feature-->
<section id ="institute-overview" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="header-section text-center">
                    <h2>Institute Overview</h2>
                    <p class="text-justify">Prime Foundation School was established in 2000 in a safe and peaceful locality with the express purpose of catering to the growing need of modern education according to international standards. In 2006 a separate first grade Kindergarten branch was established. Since its inception, Prime Kindergarten has received great commendation from the parents. In fulfilling its mission, PFS is providing high quality education to all its students, inspiring the students to develop their potential to the full, thus producing professionals and creative people. The hallmark of PFS is the quality of character building and discipline. Attractive features of our educational system are flexibility, productivity and purposefulness. At PFS classroom discipline is excellent. Students are encouraged to participate in educational and personality development activities. We have a strong monitoring and evaluation system. Performance and progress of every student is recorded, analysed and discussed regularly for the best results. Our schools are set in a "home like" environment which helps to promote a smooth transition from home life to school life. We strive to provide a child-centered environment, which nurtures children of different backgrounds. PFS offers first grade educational facilities and purposeful learning . Prime Foundation School aims to give children an all-round education offering: § A caring environment with a strong academic foundation § An exclusive focus on the individual child § A balance between local and global standards with modern approaches § Service to children, parents and the nation § Operating all our work places in a safe and healthy environment and improve employee satisfaction.</p>
                    <hr class="bottom-line">
                </div>
                <div class="feature-info">
                    <div class="fea">
                        <div class="col-md-6">
                            <div class="heading pull-right">
                                <h4>Vision</h4>
                                <p class="text-justify">“PFS" envisions quality education as the key resource for national development, delivered to a cross section of our society through sustainable projects.</p>
                            </div>
                            <div class="fea-img pull-left">
                                <i class="fa fa-lightbulb-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="fea">
                        <div class="col-md-6">
                            <div class="heading pull-right">
                                <h4>Mission Statement</h4>
                                <p class="text-justify">Prime Foundation School will provide successful experiences for each student to attain self-esteem and the knowledge, skills, and behavior necessary to function effectively and cooperatively in society. May ALLAH Almighty help us!</p>
                            </div>
                            <div class="fea-img pull-left">
                                <i class="fa fa-compass"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ feature-->

<!--Testimonial-->
<section id="testimonial" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <div class="header-section text-center">
                    <h2 class="white">Chairman message</h2>
                    <p class="white text-justify">Dear Parents, Asslam u Alykum I strongly believe that education is the basic human right of everyone living on this planet regardless of their social background. An educated nation is a strong nation in real sense, thus educating the nation is my passion for education for the last 25 years.Though education is the primarily responsibility of a state, yet this goal cannot be accomplished without realization and struggle of by all of the stakeholders of our society.In order to enable all individuals to reach and utilize their maximum potential, education is categorically imperative. Education also combats unemployment, confirms sound foundation of social equity, awareness, tolerance and spread of political socialization and cultural vitality. To meet such challenges, we all need to extend helping-hand to one another for the generations to come.I am proud of the fact that we have been able to make a remarkable contribution for quality education in Faisalabad. We have, therefore, tried to share in the development of human resource capital from the general masses by providing affordable educational opportunities to all section of the society.I hope and desire that our education system should produce responsible, enlightened citizens to align Pakistan with the global framework of economic and social prosperity. I am confident that Prime Foundation School will suffice this dire need of our society. I, therefore, welcome to parents and their children to become part of PFS family to grow together.I believe it is today we must create the world of the future. <br>Sincerely yours,</p>
                    <hr class="bottom-line bg-white">
                </div>
            </div>

            <div class="col-xs-12 col-sm-4">

                <div class="header-section text-center cust_box cust_box_light">
                    <h2 class="cust_box_heading">News</h2>

                    <?php if ( $news === false ): ?>
                        <h3 style="opacity: 0.8;">No news uploaded</h3>
                    <?php else: ?>
                        <div class="news_ticker text-left">
                            <ul>
                                <?php foreach ( $news as $itm ): ?>
                                <li>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <?php if ( !empty( $itm[ 'image' ] ) ): ?>
                                                    <img class="img-responsive img-rounded" src="<?= base_url( $itm[ 'image' ] ) ?>">
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-sm-7">
                                                <a href="<?= site_url('home/news') ?>"><?= substr( $itm[ 'title' ], 0, 100 ) . (strlen( $itm[ 'title' ] ) > 200 ? "..." : "") ?></a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>
                
                <hr class="bottom-line bg-white">

            </div>
        </div>
    </div>
</section>
<!--/ Testimonial-->

<!--Contact-->
<section id ="contact" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="header-section text-center">
                    <h2>Drop your message</h2>
                    <p>We'll contact back soon (InShaAllah).</p>
                    <hr class="bottom-line">
                </div>
                <div id="sendmessage">Your message has been sent. Thank you!</div>
                <div id="errormessage"></div>
                <form action="<?= site_url( 'home/contact' ) ?>" method="post" role="form" class="contactForm">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 left">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control form" id="name" placeholder="Your Name" required="" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="" />
                                <div class="validation"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required="" />
                                <div class="validation"></div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 right">
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required=""></textarea>
                                <div class="validation"></div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <!-- Button -->
                            <button type="submit" id="submit" name="submit" class="form contact-form-button light-form-button oswald light">SEND EMAIL</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
<!--/ Contact-->

<!--Map-->
<section id ="Map" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="header-section text-center">
                    <h2>How to reach us</h2>
                    <p>Vision - A Step to Future.</p>
                    <hr class="bottom-line">
                </div>
            </div>

            <div class="col-sm-6">
                <div class="google-maps">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1030.4183734732776!2d73.1016731446502!3d31.411279984663388!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDI0JzQyLjYiTiA3M8KwMDYnMDUuNyJF!5e0!3m2!1sen!2s!4v1495448368100" width="600" height="450" frameborder="0" style="border:0"></iframe>
                </div>
            </div>

            <div class="col-sm-6">
                <address class="text-black">
                    <h5>Main Office</h5>
                    <p>
                        Faisalabad
                        <br>
                        1329-B , Peoples Colony # 1 , Faisalabad , Pakistan
                    </p>
                    <p>
                        Phone: +92 (41) 8732704, +(92) (41) 8724823
                        <br>
                        Email: info@pfseline.com
                    </p>
                </address>
            </div>

        </div>
    </div>
</section>
<!--/ Map-->

<script src="<?= base_url( 'js/jquery-easy-ticker/jquery.easy-ticker.min.js' ) ?>"></script>
<script type="text/javascript">
    jQuery( function ( $ ) {

        $( '.news_ticker' ).easyTicker( {
            direction: 'up',
            easing: 'swing',
            speed: 'slow',
            interval: 2000,
            height: 'auto',
            visible: 0,
            mousePause: 1,
            controls: {
                up: '',
                down: '',
                toggle: '',
                playText: 'Play',
                stopText: 'Stop'
            }
        } );

    } );
</script>

<?php $this->load->view( "templates/main_footer_view" ) ?>