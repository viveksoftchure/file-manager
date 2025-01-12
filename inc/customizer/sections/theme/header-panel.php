<?php
/**
 * Section 1 Settings
 *
 * @package BookMark
 */

add_action( 'customize_register', 'theme_customize_register_theme_header' );

function theme_customize_register_theme_header( $wp_customize ) 
{

    $wp_customize->add_section( 'header_settings', array(
        'title'          => esc_html__( 'Header settings', 'bookmark' ),
        'description'    => esc_html__( 'Header settings:', 'bookmark' ),
        'panel'          => 'theme_panel',
        'priority'       => 160,
    ) );

    /*
    * sticky header option
    */
    $wp_customize->add_setting('sticky_header', array(
        'sanitize_callback'     =>  'theme_sanitize_checkbox',
        'default'               =>  true
    ));

    $wp_customize->add_control( new Theme_Toggle_Control( 
        $wp_customize, 
        'sticky_header', array(
            'label' => esc_html__( 'Is header sticky','bookmark' ),
            'section' => 'header_settings',
            'settings' => 'sticky_header',
            'type'=> 'toggle',
        ) 
    ));

    /*
    * header style option
    */
    $wp_customize->add_setting( 'header_style', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_select',
        'default' => '1',
    ));

    $wp_customize->add_control( 'header_style', array(
        'type' => 'select',
        'section' => 'header_settings', // Add a default or your own section
        'label' => __('Header style', 'bookmark'),
        'choices' => array(
            '1' => __( 'Header 1', 'bookmark' ),
            '2' => __( 'Header 2', 'bookmark' ),
        ),
    ));
}