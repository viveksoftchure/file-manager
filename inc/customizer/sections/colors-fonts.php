<?php

/**
 * Colors and Fonts Settings
 *
 * @package BookMark
 */
add_action( 'customize_register', 'theme_customize_colors' );
function theme_customize_colors( $wp_customize )
{
    $wp_customize->get_section( 'colors' )->priority = 12;
    // $wp_customize->remove_control( 'header_textcolor' );
    $wp_customize->get_section( 'colors' )->title = esc_html__( 'Colors and Fonts', 'bookmark' );

    $wp_customize->add_setting( 'more_color_options', array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    ));
    

    $wp_customize->add_setting( 'primary_color', array(
        'default' => '#ed8a0a',
    ));
    
    // Add Controls
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
            'label' => 'Primary Color',
            'section' => 'colors',
            'settings' => 'primary_color'
    )));
    

    $wp_customize->add_setting( 'secondary_color', array(
        'default' => '#D93E40',
    ));
    
    // Add Controls
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
            'label' => 'Secondary Color',
            'section' => 'colors',
            'settings' => 'secondary_color'
    )));
}

add_action( 'customize_register', 'theme_customize_color_mode' );
function theme_customize_color_mode( $wp_customize )
{
    $wp_customize->add_setting( 'color_mode', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_select',
        'default' => 'orange',
    ) );

    $wp_customize->add_control( 'color_mode', array(
        'type' => 'select',
        'section' => 'colors', // Add a default or your own section
        'label' => __('Color Mode', 'bookmark'),
        'choices' => array(
            'default' => __( 'Default', 'bookmark' ),
            'orange' => __( 'Orange', 'bookmark' ),
            'blue' => __( 'Blue', 'bookmark' ),
        ),
    ) );
}

add_action( 'customize_register', 'theme_customize_font_family' );
function theme_customize_font_family( $wp_customize )
{
    $wp_customize->add_setting( 'body_font_family', array(
        'capability'        => 'edit_theme_options',
        'default'           => 'Nunito',
        'sanitize_callback' => 'theme_sanitize_google_fonts',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'body_font_family', array(
        'label'    => esc_html__( 'Body Font Family', 'bookmark' ),
        'section'  => 'colors',
        'type'     => 'select',
        'choices'  => theme_google_fonts(),
        'priority' => 100,
    ) );
}

add_action( 'customize_register', 'theme_customize_font_size' );
function theme_customize_font_size( $wp_customize )
{
    $wp_customize->add_setting( 'font_size', array(
        'capability'        => 'edit_theme_options',
        'default'           => '16px',
        'sanitize_callback' => 'theme_sanitize_select',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'font_size', array(
        'label'    => esc_html__( 'Choose Font Size', 'bookmark' ),
        'section'  => 'colors',
        'type'     => 'select',
        'default'  => '16px',
        'choices'  => array(
        '13px' => '13px',
        '14px' => '14px',
        '15px' => '15px',
        '16px' => '16px',
        '17px' => '17px',
        '18px' => '18px',
    ),
        'priority' => 101,
    ) );
}

add_action( 'customize_register', 'theme_font_weight' );
function theme_font_weight( $wp_customize )
{
    $wp_customize->add_setting( 'body_font_weight', array(
        'default'           => 400,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new Theme_Slider_Control( $wp_customize, 'body_font_weight', array(
        'section'  => 'colors',
        'label'    => esc_html__( 'Font Weight', 'bookmark' ),
        'priority' => 102,
        'choices'  => array(
        'min'  => 100,
        'max'  => 900,
        'step' => 100,
    ),
    ) ) );
}

add_action( 'customize_register', 'theme_line_height' );
function theme_line_height( $wp_customize )
{
    $wp_customize->add_setting( 'body_line_height', array(
        'default'           => 1.5,
        'sanitize_callback' => 'theme_sanitize_float',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new Theme_Slider_Control( $wp_customize, 'body_line_height', array(
        'section'  => 'colors',
        'label'    => esc_html__( 'Line Height', 'bookmark' ),
        'priority' => 102,
        'choices'  => array(
        'min'  => 0.1,
        'max'  => 3,
        'step' => 0.1,
    ),
    ) ) );
}

add_action( 'customize_register', 'theme_heading_options' );
function theme_heading_options( $wp_customize )
{
    $wp_customize->add_setting( 'heading_options_text', array(
        'default'           => '',
        'type'              => 'customtext',
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new Theme_Custom_Text( $wp_customize, 'heading_options_text', array(
        'label'    => esc_html__( 'Heading Options :', 'bookmark' ),
        'section'  => 'colors',
        'priority' => 103,
    ) ) );
}

add_action( 'customize_register', 'theme_heading_font_family' );
function theme_heading_font_family( $wp_customize )
{
    $wp_customize->add_setting( 'heading_font_family', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_google_fonts',
        'default'           => 'Merriweather',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'heading_font_family', array(
        'label'    => esc_html__( 'Heading Font Family', 'bookmark' ),
        'section'  => 'colors',
        'type'     => 'select',
        'choices'  => Theme_google_fonts(),
        'priority' => 103,
    ) );
}
