<?php
/**
 * Secction 3 Settings
 *
 * @package BookMark
 */

add_action( 'customize_register', 'theme_customize_register_section_3' );

function theme_customize_register_section_3( $wp_customize ) 
{
	$wp_customize->add_section( 'theme_section_3', array(
	    'title'          => esc_html__( 'Section 3', 'bookmark' ),
	    'description'    => esc_html__( 'Section 3 :', 'bookmark' ),
	    'panel'          => 'theme_homepage_panel',
	    'priority'       => 160,
	));

    /*
    * Section display option
    */
    $wp_customize->add_setting( 'theme_section_3_display_option', array(
          'sanitize_callback'     =>  'theme_sanitize_checkbox',
          'default'               =>  true
    ));

    $wp_customize->add_control( new Theme_Toggle_Control( $wp_customize, 
        'theme_section_3_display_option', 
        array(
            'label' => esc_html__( 'Hide / Show','bookmark' ),
            'section' => 'theme_section_3',
            'settings' => 'theme_section_3_display_option',
            'type'=> 'toggle',
        ) 
    ));

    /*
    * Section background color option
    */
    $wp_customize->add_setting( 'theme_section_3_background_color', array(
        'default' => '#fff',
    ));
    
    // Add Controls
    $wp_customize->add_control( new WP_Customize_Color_Control( 
        $wp_customize, 
        'theme_section_3_background_color', array(
            'label' => 'Background Color',
            'section' => 'theme_section_3',
            'settings' => 'theme_section_3_background_color'
        )
    ));

    /*
    * Section top padding option
    */
    $wp_customize->add_setting( 'theme_section_3_top_padding', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_3_top_padding', array(
        'label' => esc_html__( 'Top Padding', 'bookmark' ),
        'section' => 'theme_section_3',
        'settings' => 'theme_section_3_top_padding',
        'type'=> 'number',
    ));

    /*
    * Section bottom padding option
    */
    $wp_customize->add_setting( 'theme_section_3_bottom_padding', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_3_bottom_padding', array(
        'label' => esc_html__( 'Bottom Padding', 'bookmark' ),
        'section' => 'theme_section_3',
        'settings' => 'theme_section_3_bottom_padding',
        'type'=> 'number',
    ));

    /*
    * Section class option
    */
    $wp_customize->add_setting( 'theme_section_3_item_class', array(
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_3_item_class', array(
        'label' => esc_html__( 'Item Class', 'bookmark' ),
        'section' => 'theme_section_3',
        'settings' => 'theme_section_3_item_class',
        'type'=> 'text',
    ));

    /*
    * Section post category option
    */
    $wp_customize->add_setting( 'theme_section_3_category', array(
        'capability'  => 'edit_theme_options',       
        'default'     => array(),
    ));

    $wp_customize->add_control( new Theme_Customize_Control_Multiple_Select( 
        $wp_customize, 
        'theme_section_3_category', 
        array(
            'label' => esc_html__( 'Choose Category', 'bookmark' ),
            'section' => 'theme_section_3',
            'settings' => 'theme_section_3_category',
            'type'=> 'multiple-taxonomies',
            'taxonomy'  =>  'category'
        ) 
    ));

    /*
    * Section title option
    */
    $wp_customize->add_setting( 'theme_section_3_title', array(
        'transport' => 'postMessage',
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ) );

    $wp_customize->add_control( 'theme_section_3_title', array(
        'label' => esc_html__( 'Title', 'bookmark' ),
        'section' => 'theme_section_3',
        'settings' => 'theme_section_3_title',
        'type'=> 'text',
    ) );

    /*
    * Section Description
    */
    $wp_customize->add_setting( 'theme_section_3_desc', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'theme_section_3_desc', array(
        'label' => esc_html__( 'Section Description', 'bookmark' ),
        'section' => 'theme_section_3',
        'settings' => 'theme_section_3_desc',
        'type'=> 'text',
    ));

    /*
    * Section post count show option
    */
    $wp_customize->add_setting( 'theme_section_3_show_count', array(
        'sanitize_callback'     =>  'theme_sanitize_checkbox',
        'default'               =>  true
    ));

    $wp_customize->add_control( new Theme_Toggle_Control( 
        $wp_customize, 
        'theme_section_3_show_count', array(
        'label' => esc_html__( 'Show count','bookmark' ),
            'section' => 'theme_section_3',
            'settings' => 'theme_section_3_show_count',
            'type'=> 'toggle',
        )
    ));

    /*
    * Section hide empty category option
    */
    $wp_customize->add_setting( 'theme_section_3_hide_empty_category', array(
        'sanitize_callback'     =>  'theme_sanitize_checkbox',
        'default'               =>  true
    ));

    $wp_customize->add_control( new Theme_Toggle_Control( 
        $wp_customize, 
        'theme_section_3_hide_empty_category', array(
        'label' => esc_html__( 'Hide empty category','bookmark' ),
            'section' => 'theme_section_3',
            'settings' => 'theme_section_3_hide_empty_category',
            'type'=> 'toggle',
        )
    ));

    /*
    * Section post orderby option
    */
    $wp_customize->add_setting( 'theme_section_3_orderby', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_select',
        'default' => 'Name',
    ) );

    $wp_customize->add_control( 'theme_section_3_orderby', array(
        'type' => 'select',
        'section' => 'theme_section_3', // Add a default or your own section
        'label' => __('Post Ordering', 'bookmark'),
        'choices' => array(
            'id' => __( 'ID', 'bookmark' ),
            'Count' => __( 'Count', 'bookmark' ),
            'Name' => __( 'Name', 'bookmark' ),
            'Slug' => __( 'Slug', 'bookmark' ),
        ),
    ) );

    /*
    * Section post order option
    */
    $wp_customize->add_setting( 'theme_section_3_order', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_select',
        'default' => 'ASC',
    ) );

    $wp_customize->add_control( 'theme_section_3_order', array(
        'type' => 'select',
        'section' => 'theme_section_3', // Add a default or your own section
        'label' => __('Ordering', 'bookmark'),
        'choices' => array(
            'ASC' => __( 'ASC', 'bookmark' ),
            'DESC' => __( 'DESC', 'bookmark' ),
        ),
    ) );


    $wp_customize->selective_refresh->add_partial( 'theme_section_3_display_option', array(
	    'selector' => '.blogs > .container',
	) );
}