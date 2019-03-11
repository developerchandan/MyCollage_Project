<?php

/**
 * Single Forum
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

    	<?php while ( have_posts() ) : the_post(); ?>

    		<?php if ( bbp_user_can_view_forum() ) : ?>

    			<div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-content">
    				<div class="entry-content">

    					<?php bbp_get_template_part( 'content', 'single-forum' ); ?>

    				</div>
    			</div><!-- #forum-<?php bbp_forum_id(); ?> -->

    		<?php else : // Forum exists, user no access ?>

    			<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

    		<?php endif; ?>

    	<?php endwhile; ?>

    </main><!-- END .large-8 columns mobile-four -->

    <?php if( $sidebar['sidebar_active'] ) { ?>

        <aside class="<?php echo $sidebar['sidebar_class']; ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
    		<div id="sidebar-main" class="sidebar">
    			<?php get_sidebar('Internal Sidebar'); ?>
    		</div><!--sidebar-main-->
    	</aside>

    <?php } ?>

</div><!-- END .row -->

<?php get_footer(); ?>