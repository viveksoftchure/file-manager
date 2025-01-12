<?php
if( ! function_exists( 'theme_register_custom_controls' ) ) :
/**
 * Register Custom Controls
*/
function theme_register_custom_controls( $wp_customize ) {
    
    // Load our custom control.
    require_once get_template_directory() . '/inc/custom-controls/sortable/class-sortable-control.php';
    require_once get_template_directory() . '/inc/custom-controls/toggle/class-toggle-control.php';
    require_once get_template_directory() . '/inc/custom-controls/dropdown-taxonomies/class-dropdown-taxonomies-control.php';
    require_once get_template_directory() . '/inc/custom-controls/dropdown-multi-taxonomies/class-dropdown-multi-taxonomies-control.php';
    require_once get_template_directory() . '/inc/custom-controls/slider/class-slider-control.php';
    require_once get_template_directory() . '/inc/custom-controls/select/class-select-control.php';

    require_once get_template_directory() . '/inc/custom-controls/notes.php';

    
    // Register the control type.
    $wp_customize->register_control_type( 'Theme_Control_Sortable' );
    $wp_customize->register_control_type( 'Theme_Toggle_Control' );
    $wp_customize->register_control_type( 'Theme_Slider_Control' );
    $wp_customize->register_control_type( 'Theme_Select_Control' );

 
}
endif;
add_action( 'customize_register', 'theme_register_custom_controls' );