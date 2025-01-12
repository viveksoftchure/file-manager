<?php

/**
 * Custom template tags for this theme
 *
 * @package file-manager
 */


/**
 * add class to excerpt
 */
function theme_add_class_to_excerpt($excerpt)
{
	return str_replace('<p', '<p class="mb-2"', $excerpt);
}
add_filter('the_excerpt', 'theme_add_class_to_excerpt');

/**
 * return excerpt more
 */
function theme_excerpt_more($more)
{
	if (!is_admin()) 
	{
		return '...';
	}
}
add_filter('excerpt_more', 'theme_excerpt_more');

/**
* theme posted on
*/
if (!function_exists('theme_posted_on'))
{
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function theme_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published visually-hidden" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date()),
			esc_attr(get_the_modified_date(DATE_W3C)),
			esc_html(get_the_modified_date())
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x('%s', 'post date', 'wpwebguru'),
			'<a href="' . esc_url(get_permalink()) . '" title="' . esc_html(get_the_title()) . '" rel="bookmark" class="text-decoration-none">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
}

/**
* theme posted by
*/
if (!function_exists('theme_posted_by'))
{
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function theme_posted_by()
	{
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x('%s', 'post author', 'wpwebguru'),
			'<span><a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_html(get_the_author()) . '" class="text-decoration-none">' . esc_html(get_the_author()) . '</a></span>'
		);
		echo $byline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
* theme entry footer
*/
if (!function_exists('theme_entry_footer'))
{
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function theme_entry_footer()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) 
		{
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(esc_html__(' ', 'wpwebguru'));
			if ($categories_list) 
			{
				/* translators: 1: list of categories. */
				printf('<span class="cat-links me-1">' . esc_html__('%1$s', 'wpwebguru') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html_x(' ', 'list item separator', 'wpwebguru'));
			if ($tags_list) 
			{
				/* translators: 1: list of tags. */
				printf('<span class="tags-links">' . esc_html__('%1$s', 'wpwebguru') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
}

/**
* Print the next and previous posts navigation.
*/
if (!function_exists('theme_the_post_navigation')) 
{
	function theme_the_post_navigation()
	{
		the_post_navigation(
			array(
				'prev_text' => '<span>' . esc_html__('<&nbsp;', 'wpwebguru') . '</span> <span>%title</span>',
				'next_text' => '<span>%title</span> <span>' . esc_html__('&nbsp;>', 'wpwebguru') . '</span>',
			)
		);
	}
}

/**
* Print numbered pagination
*/
if (!function_exists('theme_the_posts_pagination')) 
{
	/**
	 * Print the next and previous posts navigation.
	 *
	 * @return void
	 */
	function theme_the_posts_pagination()
	{
		the_posts_pagination(
			array(
				'type' => 'list',
				'class' => 'my-2',
				'mid_size' => 1,
				'end_size' => 2,
			)
		);
	}
}

/**
 * Blog Pagination
 */
if(!function_exists('theme_blog_pagination'))
{
    function theme_blog_pagination()
    {
        GLOBAL $wp_query;
        if ($wp_query->post_count < $wp_query->found_posts) {
            ?>
            <div class="post-pagination"> <?php
                the_posts_pagination(array(
                    'prev_text'          => '<i class="fa-solid fa-chevron-left"></i>',
                    'next_text'          => '<i class="fa-solid fa-chevron-right"></i>',
                    'type'               => 'list',
                    'show_all'  	     => false,
                    'end_size'           => 1,
                    'mid_size'           => 8,
                )); ?>
            </div>
            <?php
        }
    }
}


/**
 * Function that defines post navigation.
 */
if(!function_exists('theme_posts_block_navigation')) 
{
	function theme_posts_block_navigation() 
	{
		$next_post = get_next_post();
	    $previous_post = get_previous_post();

	    // echo '<pre>'; print_r($next_post); echo '</pre>'; exit;

	    ?>
	    <div class="col-md-6">
		    <?php
		    if( !empty( $next_post ) ) 
		    {
		    	?>
		    	<div class="post prev-post">
	                <a href="<?= esc_url( get_permalink($next_post->ID) ) ?>" class="flex">
	                    <div class="featured-image">
	                        <?= get_the_post_thumbnail($next_post->ID, 'thumbnail' ) ?>
	                    </div>
	                    <div class="content-wrap">
	                        <div class="nav-text">Newer article</div>
	                        <h4 class="title h5"><?= esc_html($next_post->post_title) ?></h4>
	                        <div class="post-meta">
	                            <time class="post-date" datetime="2021-05-02"><?= esc_html($next_post->post_date) ?></time>
	                            <span class="read-time"><?= theme_content_estimated_reading_time($next_post->post_content); ?></span>
	                        </div>
	                    </div>
	                </a>
	            </div>
                <?php
		    }
		    ?>
		</div>

		<div class="col-md-6">
		    <?php
		    if( !empty( $previous_post ) ) 
		    {
		    	?>
		    	<div class="post next-post">
                    <a href="<?= esc_url( get_permalink($previous_post->ID) ) ?>" class="flex">
                        <div class="featured-image">
                            <?= get_the_post_thumbnail($previous_post->ID, 'thumbnail' ) ?>
                        </div>
                        <div class="content-wrap">
                            <div class="nav-text">Older article</div>
                            <h4 class="title h5"><?= esc_html($previous_post->post_title) ?></h4>
                            <div class="post-meta">
                                <time class="post-date" datetime="2021-05-02">May 02, 2021</time>
                                <span class="read-time"><?= theme_content_estimated_reading_time($previous_post->post_content); ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
		    }
		    ?>
		</div>
		<?php
	}
}

/**
 * theme_post_category_meta
 */
function theme_post_category_meta($show = true)
{
    if (has_category()) 
    {
        $categories = get_the_category();

        if (!empty($categories)) 
        {
            foreach( $categories as $category ) 
            { 
			    $t_id = $category->term_id;
			    $cat_meta = get_option("category_$t_id");
            	?>
                <a class="" href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>" title="" style="background: <?= $cat_meta['color'] ?>;">
                    <?php echo esc_html($category->name) ?>
                </a> 
                <?php
            }
        }

    }
}

/**
 * theme_post_category_meta
 */
function theme_all_category_meta($show = true)
{
	$categories = get_terms( array(
        'taxonomy' 			=> 'category',
        'hide_empty' 		=> false,
    ) );

    if (!empty($categories)) 
    {
        foreach( $categories as $category ) 
        { 
		    $t_id = $category->term_id;
		    $cat_meta = get_option("category_$t_id");
        	?>
            <a class="" href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>" title="" style="background: <?= $cat_meta['color'] ?>;">
                <?php echo esc_html($category->name) ?>
            </a> 
            <?php
        }
    }
}

/**
 * theme_post_meta
 */
function theme_postmeta()
{
	global $current_user;
	$post_id = get_the_id();
	$is_bookmarked = is_bookmarked($post_id, $current_user->ID);
    ?>
    <time class="post-date" datetime="2021-05-02"><?php echo get_the_time(get_option('date_format')); ?></time>
    <span class="read-time"><?php echo theme_content_estimated_reading_time(get_the_content()); ?></span>
    <span class="post-meta-comments"><?php comments_popup_link(esc_html__('No Comments', 'blogar'), esc_html__('1 Comment', 'blogar'), esc_html__('% Comments', 'blogar'), 'post-comment', esc_html__('Comments off', 'blogar')); ?></span>

    <div class="add-bookmark">
    	<?php if($is_bookmarked): ?>
	    	<a href="#" class="bookmark-btn bookmarked" data-action="deletebookmark" data-post="<?= $post_id ?>" data-bookmark-active="true" title="Remove from Favorites" aria-label="Remove from Favorites"><i class="fa-solid fa-heart"></i></a>
	    <?php else: ?>
	    	<a href="#" class="bookmark-btn" data-action="addbookmark" data-post="<?= $post_id ?>" data-bookmark-active="false" title="Add to Favorites" aria-label="Add to Favorites"><i class="fa-solid fa-heart"></i></a>
		<?php endif; ?>
	</div>
    <?php
}

/**
* Single post meta
*/
function theme_singlepostmeta()
{
	global $current_user;
	$post_id = get_the_id();
	$is_bookmarked = is_bookmarked($post_id, $current_user->ID);
    ?>
    <div class="author-list flex">
    	<a class="author-image" href="<?= esc_url(get_author_posts_url(get_the_author_meta('ID', get_the_author_meta( 'ID' ) ))) ?>" aria-label="Harini Banerjee">
    		<?php echo get_avatar(get_the_author_meta('ID'), 50); ?>
    	</a>
        <a href="<?= esc_url(get_author_posts_url(get_the_author_meta('ID', get_the_author_meta( 'ID' ) ))) ?>" class="author-name"><?= get_the_author_meta('display_name', get_the_author_meta( 'ID' )) ?></a>&nbsp;
    </div>
    <time class="post-date" datetime="2021-05-02"><?php echo get_the_time(get_option('date_format')); ?></time>
    <span class="read-time"><?php echo theme_content_estimated_reading_time(get_the_content()); ?></span>

    <div class="add-bookmark">
    	<?php if($is_bookmarked): ?>
	    	<a href="#" class="bookmark-btn bookmarked" data-action="deletebookmark" data-post="<?= $post_id ?>" data-bookmark-active="true" title="Remove from Favorites" aria-label="Remove from Favorites"><i class="fa-solid fa-heart"></i></a>
	    <?php else: ?>
	    	<a href="#" class="bookmark-btn" data-action="addbookmark" data-post="<?= $post_id ?>" data-bookmark-active="false" title="Add to Favorites" aria-label="Add to Favorites"><i class="fa-solid fa-heart"></i></a>
		<?php endif; ?>
	</div>
	<?php 
}

/**
 * theme_card_authormeta
 */
function theme_card_authormeta()
{
	global $current_user;
	$post_id = get_the_id();
	$is_bookmarked = is_bookmarked($post_id, $current_user->ID);
    ?>
	<div class="author-avatar-wrap">
        <a href="<?= esc_url(get_author_posts_url(get_the_author_meta('ID', get_the_author_meta( 'ID' ) ))) ?>" class="author-image">
            <?php echo get_avatar(get_the_author_meta('ID'), 50); ?>
        </a>
    </div>
    <div class="meta-info">
        <div class="author-names">
            <a href="<?= esc_url(get_author_posts_url(get_the_author_meta('ID', get_the_author_meta( 'ID' ) ))) ?>"><?= get_the_author_meta('display_name', get_the_author_meta( 'ID' )) ?></a>
        </div>
        <div class="date-time">
            <time class="post-date" datetime="2021-05-02"><?php echo get_the_time(get_option('date_format')); ?></time>
            <span class="read-time"><?php echo theme_content_estimated_reading_time(get_the_content()); ?></span>
        </div>

	    <div class="add-bookmark">
	    	<?php if($is_bookmarked): ?>
		    	<a href="#" class="bookmark-btn bookmarked" data-action="deletebookmark" data-post="<?= $post_id ?>" data-bookmark-active="true" title="Remove from Favorites" aria-label="Remove from Favorites"><i class="fa-solid fa-heart"></i></a>
		    <?php else: ?>
		    	<a href="#" class="bookmark-btn" data-action="addbookmark" data-post="<?= $post_id ?>" data-bookmark-active="false" title="Add to Favorites" aria-label="Add to Favorites"><i class="fa-solid fa-heart"></i></a>
			<?php endif; ?>
		</div>
    </div>
    <?php
}

/**
 * theme_card_postmeta
 */
function theme_card_postmeta()
{
	?>
    <div class="post-card-meta">
    	<div class="post-comment-like">
    		<button class="post-liked" title="Liked" ><svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11.995 7.23319C10.5455 5.60999 8.12832 5.17335 6.31215 6.65972C4.49599 8.14609 4.2403 10.6312 5.66654 12.3892L11.995 18.25L18.3235 12.3892C19.7498 10.6312 19.5253 8.13046 17.6779 6.65972C15.8305 5.18899 13.4446 5.60999 11.995 7.23319Z" clip-rule="evenodd"></path></svg><span class="ml-1 text-rose-600">773</span></button>
	        <div class="post-meta-comments"><i class="far fa-comment-dots"></i> <?php comments_popup_link(esc_html__('No Comments', 'blogar'), esc_html__('1 Comment', 'blogar'), esc_html__('% Comments', 'blogar'), 'post-comment', esc_html__('Comments off', 'blogar')); ?></div>
    	</div>
    	<div class="post-meta-reading-time">
        	<span><?php echo theme_content_estimated_reading_time(get_the_content()); ?></span>
    	</div>
    </div>
    <?php
}

/**
 * theme about author box
 */
function theme_author_box()
{
	?>
    <div class="about-author flex">
        <div class="avatar-wrap">
            <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ))); ?>" title="Harini Banerjee">
            	<?php echo get_avatar(get_the_author_meta('ID'), 50); ?>
            </a>
        </div>
        <div class="author-info">
            <h3 class="name h5"><a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ))); ?>"><?= get_the_author_meta('display_name', get_the_author_meta( 'ID' )) ?></a></h3>
            <div class="bio"><?php the_author_meta('user_description'); ?></div>
        </div>
    </div>
    <?php
}