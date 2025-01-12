<?php

/**
 * Colors and Fonts Settings
 *
 * @package BookMark
 */
function theme_customizer_site_identity($wp_customize) 
{ 
    $wp_customize->add_setting('dark_logo', array(
        'default' => get_theme_file_uri('assets/images/logo-light.png'), // Add Default Image URL 
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'dark_logo_control', array(
        'label' => 'Dark Logo',
        'priority' => 8,
        'section' => 'title_tagline',
        'settings' => 'dark_logo',
        'button_labels' => array(// All These labels are optional
                    'select' => 'Select Logo',
                    'remove' => 'Remove Logo',
                    'change' => 'Change Logo',
                    )
    )));
 
}
 
add_action( 'customize_register', 'theme_customizer_site_identity' );