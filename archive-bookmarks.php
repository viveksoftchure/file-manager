<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package file-manager
 */
get_header();
// Get Value
$theme_blog_sidebar_class = 'col-lg-8 col-md-12 col-12 order-1 order-lg-2';

$category = get_category( get_query_var( 'cat' ) );
$cat_id = $category->cat_ID;
$cat_meta = get_option("category_$cat_id");

// echo '<pre>'; print_r($cat_meta); echo '</pre>';
?>
<!-- Start Blog Area  -->
<div class="main">
    <div class="container">
        <div class="archive-cover">
            <div class="archive-cover-inner cover-tag flex has-image">
                <img class="cover-image lazy" loading="lazy" src="<?= $cat_meta['background_img'] ?>" alt="tag feature image">
                <div class="cover-content-wrapper">
                    <div class="tag-info-wrap text-center">
                        <h1 class="tag-name h2"><?= $category->name; ?></h1>
                        <div class="archive-info">
                            <span class="post-count"><?= $category->count; ?> Posts</span>
                        </div>
                        <div class="tag-description">
                            <?= $category->description; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ( have_posts() ): ?>

            <div class="grid gap-6 mb-4">
                <?php
                $i = 1;
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    if($i==1):
                        get_template_part('template-parts/post-list/list', 1);
                    endif;
                    $i++;
                endwhile; ?>
            </div>
            <div class="grid gap-6 md-gap-8 md-grid-cols-2 lg-grid-cols-3 post-list-wrap" id="archive-posts">
                <?php
                /* Start the Loop */
                $i = 1;
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    if($i!=1):
                        get_template_part( 'template-parts/post-card/post-card', '2' );
                    endif;
                    $i++;
                endwhile;
                ?>
            </div>

        <?php else :

            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>

        <?php if($category->count>10): ?>
            <div class="col mt-4">
                <div class="pagination-wrap text-center" id="pagination-wrap">
                    <button class="btn" id="more_posts" data-post-box="#archive-posts" data-category="<?= $category->slug ?>"><span>Show more posts</span></button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- End Blog Area  -->
<?php
get_footer();