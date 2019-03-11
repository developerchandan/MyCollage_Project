<?php

/**
 * bbPress - Topic Archive
 *
 * @package radium framework
 * @subpackage Theme
 */

get_header();

$sidebar = radium_sidebar_loader();

get_template_part( 'includes/content/content', 'header' ); 

?>
<div class="row">

    <main class="content <?php echo $sidebar['content_class']; ?>"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Article">

    	<?php do_action( 'bbp_template_notices' ); ?>

    	<div id="topic-front" class="bbp-topics-front">
    		<div class="entry-content">

    			<?php bbp_get_template_part( 'content', 'archive-topic' ); ?>

    		</div>
    	</div><!-- #topics-front -->

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