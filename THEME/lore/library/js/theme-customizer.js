/**
 * WP Customizer scripts
 */
(function($){ "use strict";
$(document).ready(function(){

    // Header background image alignment
	wp.customize( 'header_bg_image_alignment', function( value ) {
        value.bind( function( to ) {

        	if ( 'top' === to ) {
        		$( '#header .header-bg' ).css( 'background-position', 'center top' );
        	} else if ( 'center' === to ) {
        		$( '#header .header-bg' ).css( 'background-position', 'center center' );
        	} else {
        		$( '#header .header-bg' ).css( 'background-position', 'center bottom' );
        	}

        });
    });

    // Header background overlay
	wp.customize( 'header_bg_image_overlay', function( value ) {
        value.bind( function( to ) {

			$( '#header .header-bg' ).removeClass( function (index, css) {
    			return ( css.match( /(^|\s)m-overlay\S+/g ) || [] ).join( ' ' );
			});
        	if ( to > 0 ) {
        		$( '#header .header-bg' ).addClass( 'm-overlay m-overlay-' + to );
        	}

        });
    });

    // Footer widgets number of columns
	wp.customize( 'footer_widgets_cols', function( value ) {
        value.bind( function( to ) {

            $( '#footer .widget-col' ).removeClass( function (index, css) {
    			return ( css.match( /(^|\s)col-md-\S+/g ) || [] ).join( ' ' );
			});
			var classPostfix = 12 / to;
			$( '#footer .widget-col' ).addClass( 'col-md-' + classPostfix );


        });
    });

    // Footer text
	wp.customize( 'footer_text', function( value ) {
        value.bind( function( to ) {

            $( '#footer .footer-text p' ).html( to.replace( /\n/g, '<br>' ) );

        });
    });

    // Pge 404 text
	wp.customize( 'page404_content', function( value ) {
        value.bind( function( to ) {

            $( '.error404 .post-content .c-alert-message p' ).html( to.replace( /\n/g, '<br>' ) );

        });
    });

    // Custom CSS
    wp.customize( 'custom_css_code', function( value ) {
        value.bind( function( to ) {

            if ( $( 'head .lsvr-customizer-css-code' ).length < 1 ) {
                $( 'head' ).append( '<style style="text/css" class="lsvr-customizer-css-code"></style>' );
            }
            $( 'head' ).find( '.lsvr-customizer-css-code' ).html( to );

        });
    });

});
})(jQuery);