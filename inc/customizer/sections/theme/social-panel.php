<?php
/**
 * Social links Settings
 *
 * @package BookMark
 */

add_action( 'customize_register', 'theme_customize_register_theme_social' );

function theme_customize_register_theme_social( $wp_customize ) 
{

    $wp_customize->add_section( 'social_settings', array(
        'title'          => esc_html__( 'Social Links', 'bookmark' ),
        'description'    => esc_html__( 'Social Links:', 'bookmark' ),
        'panel'          => 'theme_panel',
        'priority'       => 160,
    ) );

    /*
    * Section Description
    */
    $wp_customize->add_setting( 'social_link_fb', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'social_link_fb', array(
        'label' => esc_html__( 'Facebook Link', 'bookmark' ),
        'section' => 'social_settings',
        'settings' => 'social_link_fb',
        'type'=> 'text',
    ));

    /*
    * Section Description
    */
    $wp_customize->add_setting( 'social_link_twitter', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'social_link_twitter', array(
        'label' => esc_html__( 'Twitter Link', 'bookmark' ),
        'section' => 'social_settings',
        'settings' => 'social_link_twitter',
        'type'=> 'text',
    ));

    /*
    * Section Description
    */
    $wp_customize->add_setting( 'social_link_instagram', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'social_link_instagram', array(
        'label' => esc_html__( 'Instagram Link', 'bookmark' ),
        'section' => 'social_settings',
        'settings' => 'social_link_instagram',
        'type'=> 'text',
    ));

    /*
    * Section Description
    */
    $wp_customize->add_setting( 'social_link_git', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'social_link_git', array(
        'label' => esc_html__( 'Github Link', 'bookmark' ),
        'section' => 'social_settings',
        'settings' => 'social_link_git',
        'type'=> 'text',
    ));

    /*
    * Section Description
    */
    $wp_customize->add_setting( 'social_link_youtube', array(
        'sanitize_callback'     =>  'sanitize_text_field',
        'default'               =>  ''
    ));

    $wp_customize->add_control( 'social_link_youtube', array(
        'label' => esc_html__( 'Youtube Link', 'bookmark' ),
        'section' => 'social_settings',
        'settings' => 'social_link_youtube',
        'type'=> 'text',
    ));
}