<?php
/**
 * The template for displaying all single posts
 *
 * @package file-manager
 */
get_header();
?>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
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
                        get_template_part('template-parts/content-single', get_post_type() );

                    endwhile;

                endif;
                ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <?php wpwebguru_related_post_grid(); ?>
</div>
<?php
get_footer();
?>