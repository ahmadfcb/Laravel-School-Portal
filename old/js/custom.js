(function ( $ ) {

    // Navigation scrolls
    $( ".navbar-nav li a" ).on( 'click', function ( event ) {
        $( '.navbar-nav li' ).removeClass( 'active' );
        $( this ).closest( 'li' ).addClass( 'active' );
        var $anchor = $( this );
        var nav = $( $anchor.attr( 'href' ) );
        if ( nav.length ) {
            $( 'html, body' ).stop().animate( {
                scrollTop: $( $anchor.attr( 'href' ) ).offset().top
            }, 1500, 'easeInOutExpo' );

            event.preventDefault();
        }
    } );

    // Add smooth scrolling to all links in navbar
    $( "a.mouse-hover, a.get-quote" ).on( 'click', function ( event ) {
        var hash = this.hash;
        if ( hash ) {
            event.preventDefault();
            $( 'html, body' ).animate( {
                scrollTop: $( hash ).offset().top
            }, 1500, 'easeInOutExpo' );
        }
    } );


    function readURL( input ) {

        if ( input.files && input.files[0] ) {
            var reader = new FileReader();

            reader.onload = function ( e ) {
                $( '.image-preview' ).attr( 'src', e.target.result );
            }

            reader.readAsDataURL( input.files[0] );
        }
    }

    function delete_button_modal() {
        $( '.delete_button_modal' ).click( function () {

            var modal_container = $( $( this ).data( 'target' ) ),
                delete_url = $( this ).data( 'delete-url' ),
                registration_number = $( this ).data( 'registration-no' ),
                yes_button = $( modal_container ).find( '.yes-button' );

            yes_button.attr( 'href', delete_url ).attr( 'data-registration-no', registration_number );

            $( yes_button ).click( function ( e ) {

                var reg_no_from_modal = $( this ).data( 'registration-no' ),
                    reg_no_from_modal_input = $( this ).parents( '.modal-content' ).find( 'input[name="modal_reg_number"]' );

                if ( reg_no_from_modal != reg_no_from_modal_input.val() ) {
                    e.preventDefault();

                    reg_no_from_modal_input.parent( '.form-group' ).addClass( 'has-error' );
                    reg_no_from_modal_input.val( 'Registration no. not correct.' );
                }

            } );

        } );
    }

    function multi_form_button_process() {

        // custom form button click
        $( '.cust_form_btn' ).click( function () {

            var url = $( this ).data( 'url' ),
                form_selector = $( this ).data( 'target' );

            $( form_selector ).attr( 'action', url ).submit();
        } );

    }

    function select_all_checkbox() {
        $( ".select_all_checkbox" ).on( 'change load', function ( e ) {
            var target = $( this ).data( 'target' ),
                value = $( this ).prop( 'checked' );

            $( target ).each( function ( i, d ) {
                if ( value === true ) {
                    $( d ).prop( 'checked', true );
                } else {
                    $( d ).prop( 'checked', false );
                }
            } );
        } );
    }


    $( function () {
        delete_button_modal();

        multi_form_button_process();

        select_all_checkbox();


        $( ".show-image-preview" ).change( function () {
            readURL( this );

            if ( $( this ).css( 'display' ) == 'none' ) {
                $( this ).show();
            }
        } );

        // general delete modal
        $( '[data-target="#generalDeleteModal"]' ).click( function () {

            var url = $( this ).data( 'url' );

            $( "#generalDeleteModal .btn-del-yes" ).attr( 'href', url );

        } );
    } );

})( jQuery );