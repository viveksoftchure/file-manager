<?php
/**
 * Register custom fonts.
 */
if ( !function_exists( 'file_manager_fonts_url' ) ) :
    function file_manager_fonts_url() 
    {
        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Nunito+Sans Sans, translate this to 'off'. Do not translate into your own language. */
        if ( 'off' !== esc_attr_x( 'on', 'Red Hat Display font: on or off', 'file_manager' ) ) 
        {
            $fonts[] = 'Red Hat Display:0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900';
        }

        if ( $fonts ) 
        {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), 'https://fonts.googleapis.com/css' );
        }

        return esc_url_raw($fonts_url);
    }
endif;