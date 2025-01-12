<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package file-manager
 */

get_header();
?>
<!-- Start Error Area  -->
<div class="main">
    <div class="error-content-wrap text-center">
        <div class="error-code">404</div>
        <h1 class="error-message h3">Page not found</h1>
        <p class="message-manual">Maybe the URL is incorrect, or the page no longer exist.</p>
        <a href="<?php echo esc_url( home_url( '/' ) );?>" class="btn">Return to home page</a>
    </div>
</div>
<!-- End Error Area  -->
<?php
get_footer();