<?php
/**
 * Homepage Settings
 *
 * @package BookMark
 */

add_action( 'customize_register', 'theme_customize_register_homepage_panel' );

function theme_customize_register_homepage_panel( $wp_customize ) 
{
	$wp_customize->add_panel( 'theme_homepage_panel', array(
	    'title'       => esc_html__( 'Home page Options', 'bookmark' ),
        'capability' => 'edit_theme_options',
        'priority'    => 11,
	) );
}