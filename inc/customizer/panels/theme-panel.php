<?php
/**
 * Homepage Settings
 *
 * @package BookMark
 */


add_action('customize_register','theme_customize_register_theme_panel');
function theme_customize_register_theme_panel($wp_customize)
{
	$wp_customize->add_panel('theme_panel',array(
	    'title'       => esc_html__( 'Theme Options', 'bookmark' ),
	    'description'=> 'Theme Options',
        'capability' => 'edit_theme_options',
	    'priority'=> 10,
	));
}   