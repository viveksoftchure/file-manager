<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package file-manager
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
function theme_move_comment_field_to_bottom($fields)
{
    $temp = (isset($fields['comment'])) ? $fields['comment'] : "";
    $temp_cookies = (isset($fields['cookies'])) ? $fields['cookies'] : "";
    unset($fields['comment']);
    unset($fields['cookies']);
    $fields['comment'] = $temp;
    $fields['cookies'] = $temp_cookies;
    return $fields;
}
add_filter('comment_form_fields', 'theme_move_comment_field_to_bottom');

if( post_password_required() )
{
    return;
}

?>
<div id="comments" class="comments-area">
    <div class="leave-comment-form">
        <div id="comment-form" class="theme-comment-form mt-5">
            <div class="inner">
                <?php
                $commenter = wp_get_current_commenter();
                $req = get_option( 'require_name_email' );
                $aria_req = ( $req ? " aria-required='true'" : '' );
                $consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

                $fields = array(
                    'author' =>
                        '<div class="row row--25"><div class="ccol-lg-4 col-md-4 col-12"><div class="form-group"><label for="author">'.esc_attr__('Full Name', 'wpwebguru').'<span class="required">*</span></label><span class="focus-border"></span> <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" required aria-required="true" /></div></div>',
                    'email' =>
                        '<div class="col-lg-4 col-md-4 col-12"><div class="form-group"><label for="email">'.esc_attr__('Email ', 'wpwebguru').'<span class="required">*</span></label><span class="focus-border"></span><input id="email" name="email" class="input_half" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" required aria-required="true" /></div></div>',
                    'url' =>
                        '<div class="col-lg-4 col-md-4 col-12"><div class="form-group"><label for="url">'.esc_attr__('Website', 'wpwebguru').'</label><span class="focus-border"></span><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></div></div></div>'

                );
                $args = array(
                    'class_submit' => 'theme-button btn',
                    'label_submit' => esc_html__( 'Post Comment', 'wpwebguru' ),
                    'comment_field' =>
                        '<div class="row"><div class="col-md-12"><div class="form-group"><label for="comment">'.esc_attr__('Write your comment here… ', 'wpwebguru').'<span class="required">*</span></label><span class="focus-border"></span><textarea id="comment" name="comment" rows="3"  required aria-required="true"></textarea></div></div></div>',
                    'fields' => apply_filters( 'comment_form_default_fields', $fields ),
                    'title_reply' => esc_html__('Leave a Reply','wpwebguru'),
                    'format'            => 'xhtml'
                );
                comment_form( $args );
                ?>
            </div>
        </div>


        <?php
        if( have_comments() ):
            $comments_number = absint( get_comments_number() );
            ?>
            <div id="comment-list" class="theme-blog-comment mt-5">
                <h4 class="comment-title mb-5">
                    <?php
                    if ( 1 === $comments_number ) 
                    {
                        /* translators: %s: post title */
                        printf( esc_html_x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'wpwebguru' ), esc_html( get_the_title() ) );
                    } 
                    else 
                    {
                        echo sprintf(
                        /* translators: 1: number of comments, 2: post title */
                            _nx(
                                '%1$s reply on &ldquo;%2$s&rdquo;',
                                '%1$s replies on &ldquo;%2$s&rdquo;',
                                $comments_number,
                                'comments title',
                                'wpwebguru'
                            ),
                            number_format_i18n( $comments_number ),
                            esc_html( get_the_title() )
                        );
                    }
                    ?>
                </h4>

                <?php theme_get_post_navigation(); ?>

                <ul class="comment-list">
                    <?php
                    wp_list_comments(
                        array(
                            'style'     => 'ul',
                            'callback'  => 'wpwebguru_comment',
                            'type'      => 'all',
                            'format'    => current_theme_supports( 'html5', 'comment-list' ) ? 'html5' : 'xhtml',
                        )
                    );
                    ?>
                </ul>

                <?php theme_get_post_navigation(); ?>

                <?php
                if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
                    ?>
                    <p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'wpwebguru' ); ?></p>
                <?php
                endif;
                ?>
            </div>
        <?php
        endif;
        ?>
    </div>
</div>
<!-- .comments-area -->