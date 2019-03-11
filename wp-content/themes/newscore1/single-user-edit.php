<?php

/**
 * bbPress User Profile Edit
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

    	<div id="bbp-user-<?php bbp_current_user_id(); ?>" class="content bbp-single-user row">
    		<div class="entry-content">

    			<?php bbp_get_template_part( 'content', 'single-user-edit'   ); ?>

    		</div><!-- .entry-content -->
    	</div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

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