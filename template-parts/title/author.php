<?php
$author = $post->post_author;
$get_author_id = get_the_author_meta('ID');
$theme_author_website = get_the_author_meta('user_url');
$get_author_gravatar = get_avatar_url($get_author_id, array('size' => 105));

$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$comment_args = array(
    'post_author' => $get_author_id // fill in post author ID
);
$author_comments = get_comments($comment_args);
$author_total_comment = count($author_comments);
$user_info = get_userdata($author);

$author_id = get_the_author_meta('ID');
$author_info = get_userdata(get_the_author_meta( 'ID' ));
$author_role = implode(', ', $author_info->roles);

?>


<!-- Start Author Area  -->
<div class="theme-author-area theme-author-banner bg-color-grey">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="about-author">
                    <div class="media">
                        <div class="thumbnail">
                            <img src="<?php echo esc_url($get_author_gravatar); ?>"
                                 alt="<?php echo get_the_author_meta('display_name', $author) ?>" class="author image">
                        </div>
                        <div class="media-body">
                            <div class="author-info">
                                <h1 class="title"><?php echo get_the_author_meta('display_name', $author); ?></h1>
                            </div>
                            <div class="content">
                                <?php if (!empty (get_the_author_meta('description', $author))) 
                                { 
                                    ?> 
                                    <p class="b1 description"><?php echo get_the_author_meta('description', $author); ?></p> 
                                    <?php 
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Author Area  -->