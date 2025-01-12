<?php 
/**
 * Comment Form navigation
 *
 * @package file-manager
 */
?>
<nav class="comment-navigation" role="navigation">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<div class="post-link-nav">
				<i class="fa fa-angle-left"></i>
				<?php previous_comments_link( esc_html__( 'Older Comments', 'bookmark' ) ) ?>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 text-right">
			<div class="post-link-nav">
				<?php next_comments_link( esc_html__( 'Newer Comments', 'bookmark' ) ) ?>
				<i class="fa fa-angle-right"></i>
			</div>
		</div>
	</div><!-- .row -->
</nav>