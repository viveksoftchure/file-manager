<?php
/**
 * Template Name: Dashboard Template
 * Template Post Type: post, page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

get_header();
?>

<div class="main">
    <?php
    echo do_shortcode('[fm_account]');
    ?>
</div>
<?php
get_footer();