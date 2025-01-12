<?php

/**
 * Connect stylesheets & scripts
 *
 * @package file-manager
 */

function file_manager_enqueue_scripts()
{
    $body_font_family = get_theme_mod( 'body_font_family', 'Nunito' );
    $heading_font_family = get_theme_mod( 'heading_font_family', 'Merriweather' );
    $site_identity_font_family = esc_attr( get_theme_mod( 'bs_site_identity_font_family', 'Merriweather' ) );

	// Style CSS
	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', array(), time());
	wp_enqueue_style('icons', get_template_directory_uri() . '/assets/css/cc-icons.css', array(), time());

	wp_enqueue_style( 'theme-googlefonts', 'https://fonts.googleapis.com/css?family=' . esc_attr( $body_font_family ) . ':200,300,400,500,600,700,800,900|' . esc_attr( $heading_font_family ) . ':200,300,400,500,600,700,800,900|' . esc_attr( $site_identity_font_family ) . ':200,300,400,500,600,700,800,900|' );

	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/all.min.css', array(), time());
	
	// Main JS
	wp_enqueue_script('main_js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), time(), true);
    wp_localize_script( 'main_js', 'ajax_options', array(
		'js_option' => ['load_more' => '6','posts_per_page' => '10'],
		'ajax_url' => admin_url( 'admin-ajax.php' ), // WordPress AJAX
		'loadingmessage' => __('Sending user info, please wait...'),
		'required_message' => __('Please fill all required fields.'), 
		'valid_email' => __('Please Enter valid email.'),
		'loading_text' => __('Loading...'),
		'plugin_dir_url' => plugin_dir_url( __FILE__ ),	
		'redirecturl' => home_url(),
		'login_redirect' => site_url('account'),
		'register_redirect' => site_url('account'),
		'restrict_redirect' => home_url(),
		'get_favorites' => wp_create_nonce('get_favorites'),
	));

	wp_enqueue_script( "google-map", "https://maps.googleapis.com/maps/api/js?key=AIzaSyAKffa9Tduz3ey6MGGqKYGnUwH6A-_6bVY&language=en", false, false, true );
	//call back
	wp_register_script( "google-map-callback", "http://maps.googleapis.com/maps/api/js?key=AIzaSyAKffa9Tduz3ey6MGGqKYGnUwH6A-_6bVY&libraries=geometry,places&language=en&callback=chaksucity_location" , false, false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) 
	{
		wp_enqueue_script( 'comment-reply' );
	}
	

	wp_enqueue_script( 'jquery' );

	// Remove Block Styles
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('dashicons');
	// wp_dequeue_script('wp-embed');
	wp_deregister_script('wp-embed');
	// wp_deregister_script('jquery');

	if(!is_page('contact-us') )    
	{		
		wp_dequeue_script('contact-form-7'); // Dequeue JS Script file.
		wp_dequeue_style('contact-form-7');  // Dequeue CSS file. 
	}

}
add_action('wp_enqueue_scripts', 'file_manager_enqueue_scripts');


function admin_enqueue_scripts()
{
	// Style CSS
	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/admin.css', array(), time());

}
add_action('admin_enqueue_scripts', 'admin_enqueue_scripts');