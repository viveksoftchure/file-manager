<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package file-manager
 */

get_header();
// Get Value
$theme_blog_sidebar_class = 'col-lg-8 col-md-12 col-12 order-1 order-lg-2';
?>
<div class="main">
    <div class="container">
        <?php
        $args = array( 
            'post_type' => 'bookmarks', 
            'posts_per_page' => get_option( 'posts_per_page' ),
            'paged'=> $paged,
        ); 
        $query = new WP_Query( $args );

        ?>
        <?php if ( $query->have_posts() ): ?>
            <ul class="columns column-4">
                <?php 
                while ( $query->have_posts() ) :
                    $query->the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part('template-parts/bookmark/content');
                endwhile; ?>
            </ul>

        <?php else :

            get_template_part( 'template-parts/content', 'none' );

        endif; ?>
    </div>   
</div>
<!-- End Blog Area  -->
<?php
get_footer();