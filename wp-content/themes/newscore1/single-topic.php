<?php

/**
 * Single Topic
 *
 * @package radium framework
 * @subpackage Theme
 */

get_header();

$sidebar = radium_sidebar_loader(radium_get_option('bbpress_layout', false, 'right') );

get_template_part( 'includes/content/content', 'header' ); 

?>
<div class="row">

    <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Article">

    	<?php do_action( 'bbp_template_notices' ); ?>

    	<?php if ( bbp_user_can_view_forum( array( 'forum_id' => bbp_get_topic_forum_id() ) ) ) : ?>

    		<?php while ( have_posts() ) : the_post(); ?>

    			<div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
    				<div class="entry-content">

    					<?php bbp_get_template_part( 'content', 'single-topic' ); ?>

    				</div>
    			</div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->

    		<?php endwhile; ?>

    	<?php elseif ( bbp_is_forum_private( bbp_get_topic_forum_id(), false ) ) : ?>

    		<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

    	<?php endif; ?>

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