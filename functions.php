<?php
/**
 * WpWebGuru functions and definitions
 *
 * @package file-manager
 */
if ( ! defined( 'FM_ROOT' ) ) {
	define( 'FM_ROOT', __DIR__ );
}

if ( ! defined( 'ASSETS_DIR' ) ) {
	// Replace the version number of the theme on each release.
	define( 'ASSETS_DIR', get_template_directory_uri() . '/assets/images/' );
}

/**
 * Set up theme defaults and register support for various WordPress features
 */
require FM_ROOT . '/inc/after-setup-theme.php';

/**
 * add tables on actiovate theme
 */
require FM_ROOT . '/inc/theme-tables.php';

/**
 * Enqueue scripts and styles.
 */
require FM_ROOT . '/inc/enqueue-scripts.php';

/**
 * Add preload for CDN
 */
require FM_ROOT . '/inc/resource-hints.php';

/**
 * template Functions
 */
require FM_ROOT . '/inc/template-functions.php';

/**
 * Custom control
 */
require FM_ROOT . '/inc/custom-controls/custom-control.php';

/**
 * Customizer additions.
 */
require FM_ROOT . '/inc/customizer.php';

/**
 * template tags
 */
require FM_ROOT . '/inc/template-tags.php';

/**
 * custom WordPress nav walker
 */
require FM_ROOT . '/inc/bootstrap_walker_nav_menu.php';

/**
 * Register Custom Fonts
 */
require FM_ROOT . '/inc/register-custom-fonts.php';

/**
 * Related Post
 */
require FM_ROOT . '/template-parts/post-related-grid.php';

/**
 * breadcrumb
 */
require FM_ROOT . '/template-parts/title/breadcrumb.php';

/**
 * allow svg
 */
require FM_ROOT . '/inc/allow-svg.php';

/**
 * Customizer changes css
 */
require FM_ROOT . '/inc/dynamic-css.php';


// global classes/functions
require FM_ROOT . '/inc/class/class-core-users.php';


// global classes/functions
require FM_ROOT . '/inc/custom-post-types/bookmarks.php';


// get bookmark page for admin
require FM_ROOT . '/admin/bookmarks.php';
require FM_ROOT . '/admin/bookmark-lists.php';