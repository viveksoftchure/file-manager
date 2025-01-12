<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpwebguru
 */
$thumb_size = 'blog-thumb';
$article_class = 'post-card flex post-list';
?>

<!-- Start Post List  -->
<article id="post-<?php the_ID(); ?>" <?php post_class($article_class); ?>>
    <a href="<?php the_permalink(); ?>" class="post-img-wrap" title="<?php echo the_title(); ?>">
        <?php the_post_thumbnail($thumb_size) ?>
    </a>
    <div class="post-info-wrap">
        <div class="flex post-top-meta">
            <div class="tag-wrap"><?php theme_post_category_meta(); ?></div>
        </div>
        <h2 class="h3 post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="post-excerpt"><?php the_excerpt(); ?></div>
        <div class="post-meta">
            <?php theme_postmeta(); ?>
        </div>
    </div>
</article> 
<!-- End Post List  -->