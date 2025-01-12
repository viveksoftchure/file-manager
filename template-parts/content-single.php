<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WpWebGuru
 */

?>
<!-- Start Blog Details Area  -->
<article class="single-post">
    <header class="post-header">
        <h1 class="post-title"><?php the_title(); ?></h1>
        <div class="post-meta flex">
            <?= theme_singlepostmeta() ?>
        </div>
    </header>
    <div class="featured-image-wrap">
        <?php
        if (has_post_thumbnail()) 
        { 
            ?>
            <div class="post-thumbnail position-relative  <?php echo esc_attr($alignwide); ?>">
                <?php the_post_thumbnail($thumb_size, ['class' => 'w-100']) ?>
            </div>
            <?php 
        }
        ?>
    </div>
    <div class="post-content">
        <?php the_content(); ?>
    </div>
    <div class="post-footer">
        <div class="tag-wrap">
            <?= theme_post_category_meta() ?>
        </div>
        <div class="share-wrap">
            <div class="share-title h5 text-center">Share this article:</div>
            <div class="share-links flex">
                <?= post_sharing_icon_links2() ?>
            </div>
        </div>
        <?= theme_author_box() ?>
    </div>
</article>
<div class="prev-nex-wrap">
    <div class="row">
        <?= theme_posts_block_navigation() ?>
    </div>
</div>

<?php

/**
 *  Output comments wrapper if it's a post, or if comments are open,
 * or if there's a comment number – and check for password.
 * */
if ((is_single() || is_page()) && (comments_open() || get_comments_number()) && !post_password_required()) 
{
    ?>
    <div class="theme-comment-area">
        <?php comments_template(); ?>
    </div><!-- .comments-wrapper -->
    <?php
}
?>