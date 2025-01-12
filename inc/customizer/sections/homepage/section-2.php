<?php
/**
 * Section 2 Settings
 *
 * @package BookMark
 */

add_action( 'customize_register', 'theme_customize_register_section_2' );

function theme_customize_register_section_2( $wp_customize ) 
{
    $wp_customize->add_section( 'theme_section_2', array(
        'title'          => esc_html__( 'Section 2', 'bookmark' ),
        'description'    => esc_html__( 'Section 2 :', 'bookmark' ),
        'panel'          => 'theme_homepage_panel',
        'priority'       => 160,
    ));

    /*
    * Section display option
    */
    $wp_customize->add_setting( 'theme_section_2_display_option', array(
        'sanitize_callback'     =>  'theme_sanitize_checkbox',
        'default'               =>  true
    ));

    $wp_customize->add_control( new Theme_Toggle_Control( 
        $wp_customize, 
        'theme_section_2_display_option', array(
            'label' => esc_html__( 'Hide / Show','bookmark' ),
            'section' => 'theme_section_2',
            'settings' => 'theme_section_2_display_option',
            'type'=> 'toggle',
        ) 
    ));

    /*
    * Section background color option
    */
    $wp_customize->add_setting( 'theme_section_2_background_color', array(
        'default' => '#fff',
    ));
    
    // Add Controls
    $wp_customize->add_control( new WP_Customize_Color_Control( 
        $wp_customize, 
        'theme_section_2_background_color', array(
            'label' => 'Background Color',
            'section' => 'theme_section_2',
            'settings' => 'theme_section_2_background_color'
        )
    ));

    /*
    * Section top padding option
    */
    $wp_customize->add_setting( 'theme_section_2_top_padding', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_2_top_padding', array(
        'label' => esc_html__( 'Top Padding', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_top_padding',
        'type'=> 'number',
    ));

    /*
    * Section bottom padding option
    */
    $wp_customize->add_setting( 'theme_section_2_bottom_padding', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_2_bottom_padding', array(
        'label' => esc_html__( 'Bottom Padding', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_bottom_padding',
        'type'=> 'number',
    ));

    /*
    * Section class option
    */
    $wp_customize->add_setting( 'theme_section_2_item_class', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_2_item_class', array(
        'label' => esc_html__( 'Item Class', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_item_class',
        'type'=> 'text',
    ));

    /*
    * Section post category option
    */

    $wp_customize->add_setting( 'theme_section_2_category', array(
        'capability'  => 'edit_theme_options',        
        'sanitize_callback' => 'sanitize_text_field',
        'default'     => '',
    ) );

    $wp_customize->add_control( new Theme_Customize_Dropdown_Taxonomies_Control( $wp_customize, 'theme_section_2_category', array(
        'label' => esc_html__( 'Choose Category', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_category',
        'type'=> 'dropdown-taxonomies',
        'taxonomy'  =>  'category'
    ) ) );

    /*
    * Section post style option
    */
    $wp_customize->add_setting( 'theme_section_2_post_style', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_select',
        'default' => 'list',
    ) );

    $wp_customize->add_control( 'theme_section_2_post_style', array(
        'type' => 'select',
        'section' => 'theme_section_2', // Add a default or your own section
        'settings' => 'theme_section_2_post_style',
        'label' => __('Post Style', 'bookmark'),
        'choices' => array(
            'grid' => __( 'Grid', 'bookmark' ),
            'featured' => __( 'Featured', 'bookmark' ),
            'list' => __( 'List', 'bookmark' ),
        ),
    ) );

    /*
    * Section post count option
    */
    $wp_customize->add_setting( 'theme_section_2_post_count', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_2_post_count', array(
        'label' => esc_html__( 'Post count', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_post_count',
        'type'=> 'number',
    ));

    /*
    * Section title option
    */
    $wp_customize->add_setting( 'theme_section_2_title', array(
        'transport' => 'postMessage',
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_2_title', array(
        'label' => esc_html__( 'Title', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_title',
        'type'=> 'text',
    ) );

    /*
    * Section title type option
    */
    $wp_customize->add_setting( 'theme_section_2_title_type', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_select',
        'default' => 'h2',
    ) );

    $wp_customize->add_control( 'theme_section_2_title_type', array(
        'type' => 'select',
        'section' => 'theme_section_2', // Add a default or your own section
        'settings' => 'theme_section_2_title_type',
        'label' => __('Title Type', 'bookmark'),
        'choices' => array(
            'h1' => __( 'H1', 'bookmark' ),
            'h2' => __( 'H2', 'bookmark' ),
            'h3' => __( 'H3', 'bookmark' ),
            'h4' => __( 'H4', 'bookmark' ),
            'h5' => __( 'H5', 'bookmark' ),
            'h6' => __( 'H6', 'bookmark' ),
        ),
    ) );

    /*
    * Section Description
    */
    $wp_customize->add_setting( 'theme_section_2_desc', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'theme_section_2_desc', array(
        'label' => esc_html__( 'Section Description', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_desc',
        'type'=> 'text',
    ));

    /*
    * Section post excerpt length
    */
    $wp_customize->add_setting( 'theme_section_2_post_excerpt_length', array(
        'default'               =>  '80'
    ) );

    $wp_customize->add_control( 'theme_section_2_post_excerpt_length', array(
        'label' => esc_html__( 'Post excerpt length', 'bookmark' ),
        'section' => 'theme_section_2',
        'settings' => 'theme_section_2_post_excerpt_length',
        'type'=> 'number',
    ));

    $wp_customize->selective_refresh->add_partial( 'theme_section_2_display_option', array(
        'selector' => '.blogs > .container',
    ) );

}