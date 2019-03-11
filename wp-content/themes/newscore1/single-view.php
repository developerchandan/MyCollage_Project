<?php

/**
 * Single View
 *
 * @package radium framework
 * @subpackage Theme
 */

get_header();

$sidebar = radium_sidebar_loader(radium_get_option('bbpress_layout', false, 'right') );

get_template_part( 'includes/content/content', 'header' ); 

?>
<div class="row">

    <main id="main" class="<?php echo $radium_content_class; ?> clearfix" role="main">

    	<?php do_action( 'bbp_template_notices' ); ?>

    	<div id="bbp-view-<?php bbp_view_id(); ?>" class="bbp-view">

    		<div class="entry-content">

    			<?php bbp_get_template_part( 'content', 'single-view' ); ?>

    		</div>
    	</div><!-- #bbp-view-<?php bbp_view_id(); ?> -->

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