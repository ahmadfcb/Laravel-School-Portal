</div>

</div>
</div>
</section>
<!--/ Contact-->


<script type="text/javascript">
    jQuery( function ( $ ) {
        $( '.print_target' ).click( function () {
            var target = $( this ).data( 'target' ),
                target_data = $( target ).html(),
                print_window = window.open( '<?= site_url( "home/blank-page" ) ?>' );

            $( print_window ).load( function () {
                target_data = '<div class="container-fluid">' + target_data + '</div>';
                $( print_window.document.body ).html(target_data);

                $( print_window.document.body ).find('.hidden-print').remove();

                $( print_window.document.body ).find('input, textarea').attr('placeholder', '');

                // removing links with text
                var a = $( print_window.document.body ).find('a');
                a.each(function(i, d){
                    $(d).after( $(d).text() );
                    $(d).remove();
                });

                $( print_window.document.body ).find('img').load(function (  ) {
                    print_window.print();
                });
            } );

        } );
    } );
</script>


<?php $this->load->view( "templates/main_footer_view" ) ?>