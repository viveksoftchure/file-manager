<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package file-manager
 */
get_header();
$theme_blog_sidebar_class = 'col-lg-8 col-md-12 col-12 order-1 order-lg-2';
$author_id = get_the_author_meta('ID');

$user_twitter = get_the_author_meta('user_twitter', $author_id);
$user_facebook = get_the_author_meta('user_facebook', $author_id);
$user_url = get_the_author_meta('url', $author_id);

$author_posts_count = count_user_posts($author_id);

// echo '<pre>'; print_r(get_user_meta($author_id)); echo '</pre>'; //exit;


?>
<!-- Start Blog Area  -->
<div class="main">
    <div class="archive-cover">
        <div class="archive-cover-inner cover-author flex">
            <div class="cover-content-wrapper flex">
                <div class="avatar-wrap">
                    <?php echo get_avatar($author_id, 50); ?>
                </div>
                <div class="author-info">
                    <h2 class="name h4"><?= get_the_author_meta('display_name', $author_id) ?></h2>
                    <div class="author-meta">
                        <span class="author-location"><?= get_the_author_meta('user_city', $author_id) ?></span>
                        <span class="post-count"><?= $author_posts_count ?> posts</span>
                    </div>
                    
                    <div class="bio"><?php the_author_meta('user_description'); ?></div>
                    <div class="author-social">
                        <?php if($user_twitter): ?>
                            <a href="<?= $user_twitter ?>" target="_blanK" rel="noopener"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg></a>
                        <?php endif; ?>
                        <?php if($user_facebook): ?>
                            <a href="<?= $user_facebook ?>" target="_blanK" rel="noopener"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path></svg></a>
                        <?php endif; ?>
                        <?php if($user_url): ?>
                            <a href="<?= $user_url ?>" target="_blanK" rel="noopener"><svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.034.002C18.634.022 24 5.395 24 12c0 6.605-5.365 11.98-11.966 11.998l-.01.002h-.003l-.003-.001h-.007L12 24C5.383 24 0 18.617 0 12 0 5.384 5.383 0 12 0h.01a.244.244 0 00.017.002h.007zM8.494 10.8c.368-3.926 2.377-6.66 3.537-7.924 1.2 1.286 3.178 3.994 3.52 7.924H8.495zm-2.416 0a15.773 15.773 0 012.848-7.885C5.503 4.076 2.946 7.114 2.483 10.8h3.595zm-3.595 2.4h3.59a15.482 15.482 0 002.815 7.873c-3.404-1.172-5.943-4.2-6.405-7.873zm12.657 7.862a15.748 15.748 0 002.83-7.862h3.546c-.46 3.662-2.987 6.684-6.376 7.862zm.414-7.862H8.496a13.222 13.222 0 003.518 7.93c1.16-1.264 3.173-3.998 3.54-7.93zm5.962-2.4h-3.542a15.471 15.471 0 00-2.794-7.847c3.37 1.188 5.879 4.199 6.336 7.847z"></path></svg></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 post-list-wrap" id="author-posts">
                <h2 class="h4 section-title"><span>Featured posts</span></h2>
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

                else :

                    get_template_part( 'template-parts/content', 'none' );

                endif;
                ?>
            </div>
        </div>
    </div>
    <?php if($author_posts_count>10): ?>
        <div class="row">
            <div class="col">
                <div class="pagination-wrap text-center" id="pagination-wrap">
                    <button class="btn" id="more_posts" data-post-box="#author-posts" data-category="" data-author="<?= $author_id ?>"><span>Show more posts</span></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- End Blog Area  -->
<?php
get_footer();