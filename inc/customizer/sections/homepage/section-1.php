<?php
/**
 * Section 1 Settings
 *
 * @package BookMark
 */

add_action( 'customize_register', 'theme_customize_register_section_1' );

function theme_customize_register_section_1( $wp_customize ) 
{
    $wp_customize->add_section( 'theme_section_1', array(
        'title'          => esc_html__( 'Section 1', 'bookmark' ),
        'description'    => esc_html__( 'Section 1 :', 'bookmark' ),
        'panel'          => 'theme_homepage_panel',
        'priority'       => 160,
    ));

    /*
    * Section display option
    */
    $wp_customize->add_setting( 'theme_section_1_display_option', array(
        'sanitize_callback'     =>  'theme_sanitize_checkbox',
        'default'               =>  true
    ));

    $wp_customize->add_control( new Theme_Toggle_Control( 
        $wp_customize, 
        'theme_section_1_display_option', array(
            'label' => esc_html__( 'Hide / Show','bookmark' ),
            'section' => 'theme_section_1',
            'settings' => 'theme_section_1_display_option',
            'type'=> 'toggle',
        ) 
    ));

    /*
    * Section background color option
    */
    $wp_customize->add_setting( 'theme_section_1_background_color', array(
        'default' => '#fff',
    ));
    
    // Add Controls
    $wp_customize->add_control( new WP_Customize_Color_Control( 
        $wp_customize, 
        'theme_section_1_background_color', array(
            'label' => 'Background Color',
            'section' => 'theme_section_1',
            'settings' => 'theme_section_1_background_color'
        )
    ));

    /*
    * Section top padding option
    */
    $wp_customize->add_setting( 'theme_section_1_top_padding', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_1_top_padding', array(
        'label' => esc_html__( 'Top Padding', 'bookmark' ),
        'section' => 'theme_section_1',
        'settings' => 'theme_section_1_top_padding',
        'type'=> 'number',
    ));

    /*
    * Section bottom padding option
    */
    $wp_customize->add_setting( 'theme_section_1_bottom_padding', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_1_bottom_padding', array(
        'label' => esc_html__( 'Bottom Padding', 'bookmark' ),
        'section' => 'theme_section_1',
        'settings' => 'theme_section_1_bottom_padding',
        'type'=> 'number',
    ));

    /*
    * Section class option
    */
    $wp_customize->add_setting( 'theme_section_1_item_class', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_1_item_class', array(
        'label' => esc_html__( 'Item Class', 'bookmark' ),
        'section' => 'theme_section_1',
        'settings' => 'theme_section_1_item_class',
        'type'=> 'text',
    ));

    /*
    * Section title option
    */
    $wp_customize->add_setting( 'theme_section_1_title', array(
        'transport' => 'postMessage',
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_1_title', array(
        'label' => esc_html__( 'Title', 'bookmark' ),
        'section' => 'theme_section_1',
        'settings' => 'theme_section_1_title',
        'type'=> 'text',
    ) );

    /*
    * Section title type option
    */
    $wp_customize->add_setting( 'theme_section_1_title_type', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_select',
        'default' => 'h2',
    ) );

    $wp_customize->add_control( 'theme_section_1_title_type', array(
        'type' => 'select',
        'section' => 'theme_section_1', // Add a default or your own section
        'settings' => 'theme_section_1_title_type',
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
    $wp_customize->add_setting( 'theme_section_1_desc', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'theme_section_1_desc', array(
        'label' => esc_html__( 'Section Description', 'bookmark' ),
        'section' => 'theme_section_1',
        'settings' => 'theme_section_1_desc',
        'type'=> 'textarea',
    ));

    /*
    * Section Image
    */
    $wp_customize->add_setting('theme_section_1_img', array(
        'default' => get_theme_file_uri('assets/images/logo-light.png'), // Add Default Image URL 
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_section_1_img_control', array(
        'label' => 'Circle Image',
        'priority' => 8,
        'section' => 'theme_section_1',
        'settings' => 'theme_section_1_img',
        'button_labels' => array(// All These labels are optional
                    'select' => 'Select Image',
                    'remove' => 'Remove Image',
                    'change' => 'Change Image',
                    )
    )));

    $wp_customize->selective_refresh->add_partial( 'theme_section_1_display_option', array(
        'selector' => '.blogs > .container',
    ) );

}