<?php

/**
 * Single Reply
 *
 * @package radium framework
 * @subpackage Theme
 */

get_header();

$sidebar = radium_sidebar_loader(radium_get_option('bbpress_layout', false, 'right') );

get_template_part( 'includes/content/content', 'header' ); 

?>
<div class="row">

    <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Comment">

    	<?php do_action( 'bbp_template_notices' ); ?>

    	<?php while ( have_posts() ) : the_post(); ?>

    		<div id="bbp-reply-wrapper-<?php bbp_reply_id(); ?>" class="bbp-reply-wrapper">

    			<div class="entry-content">

    				<div class="bbp-replies" id="topic-<?php bbp_topic_id(); ?>-replies">
    						<div>
    							<div class="bbp-reply-author"><?php  _e( 'Author',  'radium' ); ?></div>
    							<div class="bbp-reply-content"><?php _e( 'Replies', 'radium' ); ?></div>
    						</div>

    						<div><?php bbp_topic_admin_links(); ?></div>

    						<div class="bbp-reply-header">
    							<div class="bbp-reply-author">

    								<?php bbp_reply_author_display_name(); ?>

    							</div>
    							<div class="bbp-reply-content">
    								<a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>">#</a>

    								<?php printf( __( 'Posted on %1$s at %2$s', 'radium' ), get_the_date(), esc_attr( get_the_time() ) ); ?>

    								<span><?php bbp_reply_admin_links(); ?></span>
    							</div>
    						</div>

    						<div id="reply-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>

    							<div class="bbp-reply-author"><?php bbp_reply_author_link( array( 'type' => 'avatar' ) ); ?></div>

    							<div class="bbp-reply-content">

    								<?php bbp_reply_content(); ?>

    							</div>

    						</div><!-- #topic-<?php bbp_topic_id(); ?>-replies -->
    					</div>

    			</div><!-- .entry-content -->
    		</div><!-- #bbp-reply-wrapper-<?php bbp_reply_id(); ?> -->

    	<?php endwhile; ?>

</main><!-- #main -->

    <?php if( $sidebar['sidebar_active'] ) { ?>

        <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
    		<div id="sidebar-main" class="sidebar">
    			<?php get_sidebar('Internal Sidebar'); ?>
    		</div><!--sidebar-main-->
    	</aside>

    <?php } ?>

</div><!-- END .row -->

<?php get_footer(); ?>