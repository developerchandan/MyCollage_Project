<?php

/**
 * Template Name: bbPress - Statistics
 *
 * @package radium framework
 * @subpackage Theme
 */

// Get the statistics and extract them for later use in this template
// @todo - remove variable references
extract( bbp_get_statistics(), EXTR_SKIP );

get_header();

$sidebar = radium_sidebar_loader();

?>

<?php get_template_part( 'includes/content/content', 'header' ); ?>

<div class="row page-content">

    <main id="main" class="<?php echo $sidebar['content_class']; ?> clearfix" role="main">

				<?php do_action( 'bbp_template_notices' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<div id="bbp-statistics" class="bbp-statistics">
						<div class="entry-content">

							<?php get_the_content() ? the_content() : _e( '<p>Here are the statistics and popular topics of our forums.</p>', 'radium' ); ?>

							<dl role="main">

								<?php do_action( 'bbp_before_statistics' ); ?>

								<dt><?php _e( 'Registered Users', 'radium' ); ?></dt>
								<dd>
									<strong><?php echo $user_count; ?></strong>
								</dd>

								<dt><?php _e( 'Forums', 'radium' ); ?></dt>
								<dd>
									<strong><?php echo $forum_count; ?></strong>
								</dd>

								<dt><?php _e( 'Topics', 'radium' ); ?></dt>
								<dd>
									<strong><?php echo $topic_count; ?></strong>
								</dd>

								<dt><?php _e( 'Replies', 'radium' ); ?></dt>
								<dd>
									<strong><?php echo $reply_count; ?></strong>
								</dd>

								<dt><?php _e( 'Topic Tags', 'radium' ); ?></dt>
								<dd>
									<strong><?php echo $topic_tag_count; ?></strong>
								</dd>

								<?php if ( !empty( $empty_topic_tag_count ) ) : ?>

									<dt><?php _e( 'Empty Topic Tags', 'radium' ); ?></dt>
									<dd>
										<strong><?php echo $empty_topic_tag_count; ?></strong>
									</dd>

								<?php endif; ?>

								<?php if ( !empty( $topic_count_hidden ) ) : ?>

									<dt><?php _e( 'Hidden Topics', 'radium' ); ?></dt>
									<dd>
										<strong>
											<abbr title="<?php echo esc_attr( $hidden_topic_title ); ?>"><?php echo $topic_count_hidden; ?></abbr>
										</strong>
									</dd>

								<?php endif; ?>

								<?php if ( !empty( $reply_count_hidden ) ) : ?>

									<dt><?php _e( 'Hidden Replies', 'radium' ); ?></dt>
									<dd>
										<strong>
											<abbr title="<?php echo esc_attr( $hidden_reply_title ); ?>"><?php echo $reply_count_hidden; ?></abbr>
										</strong>
									</dd>

								<?php endif; ?>

								<?php do_action( 'bbp_after_statistics' ); ?>

							</dl>

							<?php do_action( 'bbp_before_popular_topics' ); ?>

							<?php bbp_set_query_name( 'bbp_popular_topics' ); ?>

							<?php if ( bbp_has_topics( array( 'meta_key' => '_bbp_reply_count', 'posts_per_page' => 15, 'max_num_pages' => 1, 'orderby' => 'meta_value_num', 'show_stickies' => false ) ) ) : ?>

								<h2 class="entry-title"><?php _e( 'Popular Topics', 'radium' ); ?></h2>

								<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

								<?php bbp_get_template_part( 'loop',       'topics' ); ?>

								<?php bbp_get_template_part( 'pagination', 'topics' ); ?>

							<?php endif; ?>

							<?php bbp_reset_query_name(); ?>

							<?php do_action( 'bbp_after_popular_topics' ); ?>

						</div>
					</div><!-- #bbp-statistics -->

				<?php endwhile; ?>

			</div><!-- #content -->
   </main><!-- #main -->

    <?php if( $sidebar['active']) { ?>

        <aside id="sidebar" class="sidebar <?php echo $sidebar['sidebar_class']; ?>">
            <div id="sidebar-main" class="sidebar">
                <?php get_sidebar('Internal Sidebar'); ?>
            </div><!--sidebar-main-->
        </aside>

    <?php } ?>

</div><!--.row-->

<?php get_footer(); ?>
