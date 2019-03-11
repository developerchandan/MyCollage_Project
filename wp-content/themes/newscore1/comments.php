<?php /* The Comments */ ?>

<div id="comments" class="<?php if( get_comments_number( $post->ID ) == 0 ) { ?>no-comments<?php } ?>" itemscope itemtype="http://schema.org/UserComments">

	<?php 
	
	if ( post_password_required() ) : ?>
		<div class="nopassword alert info center"><?php _e('Comments are not available on this post.', 'radium') ?></div></div><!-- close comments div--><?php 
		return; 
	endif; 

	do_action( 'radium_before_comment_template' );

	/*-----------------------------------------------------------------------------------*/
	/*	DISPLAY THE COMMENTS
	/*-----------------------------------------------------------------------------------*/
	if ( have_comments() ) :

		$ping_count = $comment_count = 0;
		foreach ( $comments as $comment )
	    	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;

		if ( ! empty($comments_by_type['comment']) ) : ?>

            <h3><span><?php comments_number(__('0 Comments ', 'radium'), __('1 Comment ', 'radium'), __('% Comments ', 'radium')); ?><?php _e('on this Post', 'radium') ?></span></h3>

			<div id="comments-list" class="comments">

				<?php

                $total_pages = get_comment_pages_count();

                if ( $total_pages > 1 ) : ?>

			        <div id="comments-nav-above" class="comments-navigation">

			        	<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>

			        </div><!-- END #comments-nav-above -->

				<?php endif;

				do_action( 'radium_before_comments' );

				/* An ordered list of our custom comments callback, custom_comments(), in functions.php   */ ?>
		        	<ol>
		       			<?php wp_list_comments('type=comment&callback=radium_theme_comments'); ?>
		        	</ol>
				<?php /* If there are enough comments, build the comment navigation */

				$total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>

		        	<div id="comments-nav-below" class="comments-navigation">

		        		<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>

		       		</div><!-- END #comments-nav-below -->

				<?php endif; ?>

			</div><!-- END #comments-list .comments -->

		<?php endif;

		/*-----------------------------------------------------------------------------------*/
		/*	DISPLAY THE PINGS
		/*-----------------------------------------------------------------------------------*/

		if ( ! empty($comments_by_type['pings']) ) : ?>

		<div id="trackbacks-list" class="comments">

			<div class="entry-meta">

		    	<h3><span><?php printf($ping_count > 1 ? __('<span>%d</span> Trackbacks', 'radium') : __('<span>One</span> Trackback for this Post.', 'radium'), $ping_count) ?></span></h3>

			</div><!-- END .entry-meta -->

			<ol>
				<?php wp_list_comments('type=pings&callback=radium_custom_pings'); ?>
			</ol>

		</div><!-- END #trackbacks-list .comments -->

		<?php endif; /* if ( $ping_count ) */

		endif; /* if ( $comments ) */



	/*-----------------------------------------------------------------------------------*/
	/*	RESPOND TO COMMENTS
	/*-----------------------------------------------------------------------------------*/
	if ( comments_open() ) : ?>

		<?php comment_form(
                array(
                    'title_reply' => '<span class="comment-header">' . __( 'Leave a Comment', 'radium' ) . '</span>',
                    'title_reply_to' => '<span class="comment-header">' . __( 'Leave a Reply', 'radium' ) . '</span>',
                )
        ); ?>


	<?php endif; /* if ( get_option('comment_registration') && !$user_ID ) */

	/* Display comments disabled message if there's already comments, but commenting is disabled */

	if ( ! comments_open() && have_comments() && ! is_page() ) : ?>

		<div id="respond">

			<div class="comments-closed alert info center"><?php _e( 'Comments are closed.', 'radium' ); ?></div>

	        <?php do_action( 'radium_comments_disabled' ); ?>

	    </div>

	<?php endif; ?>

</div><!-- END #comments-respond -->