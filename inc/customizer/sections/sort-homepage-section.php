<?php

/**
 * Rearrange Sections
 *
 * @package BookMark
 */
add_action( 'customize_register', 'theme_sort_homepage_sections' );
function theme_sort_homepage_sections( $wp_customize )
{
    $wp_customize->add_section( 'theme_sort_homepage_sections', array(
        'title'    => esc_html__( 'Rearrange Home Sections', 'bookmark' ),
        'panel'    => '',
        'priority' => 13,
    ) );
    
    $default = array(
        'section-1',
        'section-2',
        'section-3',
        'section-4',
        'section-5',
        'section-6',
    );
    $choices = array(
        'section-1'         => esc_html__( 'Section 1', 'bookmark' ),
        'section-2'         => esc_html__( 'Section 2', 'bookmark' ),
        'section-3'         => esc_html__( 'Section 3', 'bookmark' ),
        'section-4'         => esc_html__( 'Section 4', 'bookmark' ),
        'section-5'         => esc_html__( 'Section 5', 'bookmark' ),
        'section-6'         => esc_html__( 'Section 6', 'bookmark' ),
    );
    
    
    $wp_customize->add_setting( 'theme_sort_homepage', array(
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_sanitize_array',
        'default'           => $default,
    ) );
    $wp_customize->add_control( new Theme_Control_Sortable( 
        $wp_customize, 
        'theme_sort_homepage', array(
            'label'   => esc_html__( 'Drag and Drop Sections to rearrange.', 'bookmark' ),
            'section' => 'theme_sort_homepage_sections',
            'type'    => 'sortable',
            'choices' => $choices,
        ) 
    ));
}
