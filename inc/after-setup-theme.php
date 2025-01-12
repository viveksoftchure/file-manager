<?php

/**
 * Theme support functions
 *
 * @package file-manager
 */

if (!function_exists('file_manager_setup')) :
	/**
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function file_manager_setup()
	{
        /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on file_manager, use a find and replace
        * to change 'file_manager' to the name of your theme in all the template files.
        */
        load_theme_textdomain( 'file_manager', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
			'menu-1' => esc_html__('Main Menu', 'file_manager'),
			'menu-2' => esc_html__('Category Menu', 'file_manager'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets'
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Post Format
         */
        add_theme_support('post-formats', array('gallery', 'link', 'quote', 'video', 'audio'));


        add_theme_support('responsive-embeds');
        add_theme_support('wp-block-styles');
        add_theme_support('editor-styles');
        add_editor_style('style-editor.css');

        // for gutenberg support
        add_theme_support( 'align-wide' );
        add_theme_support( 'editor-color-palette', array(
            array(
                'name' => esc_html__( 'Primary', 'blogar' ),
                'slug' => 'blogar-primary',
                'color' => '#3858F6',
            ),
            array(
                'name' => esc_html__( 'Secondary', 'blogar' ),
                'slug' => 'blogar-secondary',
                'color' => '#D93E40',
            ),
            array(
                'name' => esc_html__( 'Tertiary', 'blogar' ),
                'slug' => 'blogar-tertiary',
                'color' => '#050505',
            ),
            array(
                'name' => esc_html__( 'White', 'blogar' ),
                'slug' => 'blogar-white',
                'color' => '#ffffff',
            ),
            array(
                'name' => esc_html__( 'Dark Light', 'blogar' ),
                'slug' => 'blogar-dark-light',
                'color' => '#1A1A1A',
            ),
        ) );

        add_theme_support( 'editor-font-sizes', array(
            array(
                'name' => esc_html__( 'Small', 'blogar' ),
                'size' => 12,
                'slug' => 'small'
            ),
            array(
                'name' => esc_html__( 'Normal', 'blogar' ),
                'size' => 16,
                'slug' => 'normal'
            ),
            array(
                'name' => esc_html__( 'Large', 'blogar' ),
                'size' => 36,
                'slug' => 'large'
            ),
            array(
                'name' => esc_html__( 'Huge', 'blogar' ),
                'size' => 50,
                'slug' => 'huge'
            )
        ) );

        /**
         * Add Custom Image Size
         */
        add_image_size('blog-thumb', 295, 250, true);
        add_image_size('single-blog-thumb', 1440, 720, true);
        add_image_size('main-slider-thumb', 1230, 615, true);
        add_image_size('tab-post-thumb', 390, 260, true);
        add_image_size('tab-big-post-thumb', 705, 660, true);
        add_image_size('tab-small-post-thumb', 495, 300, true);
        add_image_size('grid-big-post-thumb', 600, 500, true);
        add_image_size('grid-small-post-thumb', 285, 190, true);

        add_image_size('post-grid-1', 224, 224, array('center', 'center'));
        add_image_size('post-grid-1-small', 160, 172, array('center', 'center'));
        add_image_size('post-grid-2', 388, 204, array('center', 'center'));
        add_image_size('post-grid-2-big', 613, 404, array('center', 'center'));


		// Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'file_manager_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
		add_theme_support('custom-logo', array(
            'width' => 466,
			'height' => 124,
			'flex-height' => true,
			'flex-weight' => true,
			)
		);

		// Set the content width in pixels, based on the theme's design and stylesheet
		// Priority 0 to make it available to lower priority callbacks.
		if (!isset($content_width)) {
			$content_width = 900;
		}
		function file_manager_content_width()
		{
			$GLOBALS['content-width'] = apply_filters('file_manager_content_width', 1400);
		}
		add_action('after_setup_theme', 'file_manager_content_width', 0);

        // Disables the block editor from managing widgets in the Gutenberg plugin.
        add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
        // Disables the block editor from managing widgets.
        add_filter( 'use_widgets_block_editor', '__return_false' );
	}
endif;
add_action('after_setup_theme', 'file_manager_setup');