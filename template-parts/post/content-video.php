<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blogar
 */

$video_url = axil_get_acf_data("axil_video_link");
$axil_options = Helper::axil_get_options();
$thumb_size = ($axil_options['axil_blog_sidebar'] === 'no') ? 'axil-single-blog-thumb':'axil-blog-thumb';
$post_share_icon = (isset($axil_options['axil_show_post_share_icon'])) ? $axil_options['axil_show_post_share_icon'] : 'yes';
?>
<!-- Start Post List  -->
<div id="post-<?php the_ID(); ?>" class="content-block post-list-view mt--30">
    <?php if(has_post_thumbnail()){ ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail($thumb_size, ['class' => 'w-100']) ?>
            </a>
            <?php if(!empty($video_url)){ ?>
                <div class="video-button position-to-top">
                    <a class="video-popup size-medium position-top-center icon-color-secondary" href="<?php the_permalink(); ?>"><span class="play-icon"></span></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <div class="post-content">
        <?php Helper::axil_post_category_meta(); ?>
        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
        <div class="post-meta-wrapper">
            <?php Helper::axil_postmeta(); ?>
            <?php if (function_exists('axil_sharing_icon_links') && $post_share_icon !== 'no') {
                axil_sharing_icon_links();
            } ?>
        </div>
    </div>
</div>
<!-- End Post List  -->