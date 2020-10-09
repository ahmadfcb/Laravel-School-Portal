<?php $this->load->view( "templates/main_header_view" ) ?>


<?php $this->general_library->show_error_or_msg() ?>


<section class="section-padding">

    <div class="row">
        <div class="header-section text-center">
            <h2>News</h2>
            <hr class="bottom-line">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">

            <?php
            if ( $news === false ):
                echo "<h3>There are no " . $page_entity . " added yet.</h3>";
            else:

                foreach ( $news as $news_row ):
                    ?>

                    <article class="news_article">

                        <h2 class="news_article_title"><?= $news_row[ 'title' ] ?></h2>

                        <?php
                        if ( !empty( $news_row[ 'image' ] ) ):
                            ?>
                            <div class="text-center news_article_image">
                                <img class="img-responsive" src="<?= base_url( $news_row[ 'image' ] ) ?>">
                            </div>
                            <?php
                        endif;
                        ?>

                        <div class="news_article_body">

                            <?= nl2br( $news_row[ 'description' ] ) ?>

                        </div>

                    </article>

                    <?php
                endforeach;

                // pagination
                echo '<div class="text-center">' . $this->pagination->create_links() . '</div>';

            endif;
            ?>

        </div>
    </div>

</section>


<?php $this->load->view( "templates/main_footer_view" ) ?>