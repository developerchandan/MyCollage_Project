<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<li class="bbp-forum-info <?php if($post->post_content != "") { ?> has-desc <?php } ?>">

		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>" title="<?php bbp_forum_title(); ?>"><?php bbp_forum_title(); ?></a>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>

		<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

		<?php bbp_list_forums(); ?>

		<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

		<?php if($post->post_content != "") : ?><div class="bbp-forum-content"><?php the_content(); ?></div> <?php endif; ?>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php bbp_forum_row_actions(); ?>

	</li>

	<li class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?></li>

	<li class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></li>

	<li class="bbp-forum-freshness">

		<?php do_action( 'bbp_theme_before_forum_freshness_link' ); ?>

		<p class="bbp-topic-meta">

			<span class="bbp-topic-freshness-author"><?php printf( __( 'Last post by %1$s %2$s', 'radium' ), 
				bbp_get_author_link( array( 'post_id' => bbp_get_forum_last_active_id(), 'type' => 'name' ) ).'<br>', 
				bbp_get_forum_last_active_time()
		); ?></span>
			
		</p>
		
		<?php do_action( 'bbp_theme_after_forum_freshness_link' ); ?>
		
	</li>

</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
