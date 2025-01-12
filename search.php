<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package file-manager
 */

get_header();
$theme_blog_sidebar_class = 'col-lg-8 col-md-12 col-12 order-1 order-lg-2';
?>
<!-- Start Blog Area  -->
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 post-list-wrap">
                <?php
                if ( have_posts() ) :

                    /* Start the Loop */
                    while ( have_posts() ) :
                        the_post();

                        /*
                         * Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/post/content', get_post_format() );

                    endwhile;

                    theme_blog_pagination();

                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif;
                ?>
            </div>
        </div>
    </div>
</div>
<!-- End Blog Area  -->
<?php
get_footer();