<?php
/**
 * Template part for displaying header page title
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpwebguru
 */

?>
<!-- Start Breadcrumb Area  -->
<div class="theme-breadcrumb-area breadcrumb-style-1 bg-color-grey">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner">
                    <?php  if ( !is_home() ) 
                    {
                        theme_breadcrumbs();
                    } ?>
                    <?php
                    if ( is_archive() ): ?>
                        <h1 class="page-title"><?php the_archive_title(); ?></h1>
                    <?php elseif( is_search() ): ?>
                        <h1 class="page-title"><?php esc_html_e( 'Search results for: ', 'wpwebguru' ) ?><?php echo get_search_query(); ?></h1>
                    <?php else: ?>
                        <h1 class="page-title">
                            <?php echo esc_html__('Blog', 'wpwebguru'); ?>
                        </h1>
                    <?php endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area  -->