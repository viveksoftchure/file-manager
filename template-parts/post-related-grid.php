<?php
/**
 * @author  wpwebguru
 * @since   1.0
 * @version 1.0
 * @package wpwebguru
 */

if (!function_exists( 'wpwebguru_related_post_grid' )) 
{
    function wpwebguru_related_post_grid()
    {
        // Get Value
        $post_id 				= get_the_id();
        $active_post 			= array( $post_id );
        $related_post_count 	= 4;
        $query_type = 'rand';
        $args = array(
            'post__not_in'           => $active_post,
            'posts_per_page'         => $related_post_count,
            'post_status'            => 'publish',
            'no_found_rows'          => true,
            'update_post_term_cache' => false,
            'ignore_sticky_posts'    => true,
        );
        if( !empty($query_type) && isset($query_type) )
        {
            $post_order = $query_type;
            if( $post_order == 'rand' )
            {
                $args['orderby'] = 'rand';
            }
            elseif( $post_order == 'popular' )
            {
                $args['orderby'] = 'comment_count';
            }
            elseif( $post_order == 'modified' )
            {
                $args['orderby'] = 'modified';
                $args['order']   = 'ASC';
            }
            elseif( $post_order == 'recent' )
            {
                $args['orderby'] = '';
                $args['order']   = '';
            }
        }
        if( $query_type == 'author' )
        {
            $args['author'] = get_the_author_meta( 'ID' );
        }
        elseif( $query_type == 'tag' )
        {
            $tags_ids  = array();
            $post_tags = get_the_terms( $post_id, 'post_tag' );

            if( ! empty( $post_tags ) )
            {
                foreach( $post_tags as $individual_tag )
                {
                    $tags_ids[] = $individual_tag->term_id;
                }

                $args['tag__in'] = $tags_ids;
            }
        }
        else
        {
            $category_ids = array();
            $categories   = get_the_category( $post_id );
            foreach( $categories as $individual_category )
            {
                $category_ids[] = $individual_category->term_id;
            }
            $args['category__in'] = $category_ids;
        }

        $related_query = new \wp_query($args);

        if($related_query->have_posts()) 
        { 
            ?>
            <div class="related-posts-wrap">
                <h3 class="section-title h5 text-center"><?php echo esc_html( 'You might also like' ); ?></h3>
                <div class="row">
                    <?php
                    while ( $related_query->have_posts() ) 
                    {
                        $related_query->the_post();
                        $title = get_the_title();
                        $title = wp_trim_words( $title,  8 );
                        ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <article class="related-post-card" data-id="">
                                <a href="<?php the_permalink(); ?>" class="post-img-wrap" title="<?php echo esc_html($title); ?>" >
                                    <?php the_post_thumbnail('grid-small-post-thumb'); ?>
                                </a>
                                <div class="post-info-wrap">
                                    <h2 class="h5 post-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_html($title); ?>"><?php echo esc_html($title); ?></a></h2>
                                    <div class="post-meta">
                                        <time class="post-date" datetime="<?php echo get_the_time(get_option('date_format')); ?>"><?php echo get_the_time(get_option('date_format')); ?></time>
                                        <span class="read-time"><?php echo theme_content_estimated_reading_time(get_the_content()); ?></span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <?php 
                    } ?>
                </div>
            </div>
            <?php 
        }
        wp_reset_postdata();
    }
}
?>